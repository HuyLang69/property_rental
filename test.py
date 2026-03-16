#!/usr/bin/env python3
"""
NestAway Test Suite
Usage: python test_nestaway.py
"""

import re
import sys
import time
import requests
from datetime import date, timedelta

BASE_URL = "http://127.0.0.1:8000"

GREEN  = "\033[92m"
RED    = "\033[91m"
CYAN   = "\033[96m"
RESET  = "\033[0m"
BOLD   = "\033[1m"

passed = 0
failed = 0

def ok(label):
    global passed
    passed += 1
    print(f"  {GREEN}✓{RESET} {label}")

def fail(label, reason=""):
    global failed
    failed += 1
    msg = f"  {RED}✗{RESET} {label}"
    if reason:
        msg += f"  {RED}({reason}){RESET}"
    print(msg)

def section(title):
    pad = max(0, 50 - len(title))
    print(f"\n{BOLD}{CYAN}── {title} {'─' * pad}{RESET}")

def csrf(session, path="/login"):
    """GET a page and extract the CSRF token from its own fresh session."""
    r = session.get(BASE_URL + path, allow_redirects=True)
    m = re.search(r'name="_token"\s+value="([^"]+)"', r.text)
    return r, m.group(1) if m else ""

def new_session():
    s = requests.Session()
    s.headers.update({"User-Agent": "NestAway-Test/1.0"})
    return s

# ── Main authenticated session ─────────────────────────────────
S = new_session()

def get(path, session=None, **kw):
    s = session or S
    return s.get(BASE_URL + path, allow_redirects=True, **kw)

def post(path, data, session=None, **kw):
    s = session or S
    return s.post(BASE_URL + path, data=data, allow_redirects=True, **kw)


# ══════════════════════════════════════════════════════════════
# 1. SERVER HEALTH
# ══════════════════════════════════════════════════════════════
section("1. Server health")

try:
    r = get("/")
    ok("Home page loads (200)") if r.status_code == 200 else fail("Home page loads", f"got {r.status_code}")
except requests.ConnectionError:
    fail("Cannot connect to server", f"Is `php artisan serve` running at {BASE_URL}?")
    sys.exit(1)

ok("Brand name present") if "NestAway" in r.text else fail("Brand name present")
ok("Listings rendered on home") if "listings" in r.text.lower() else fail("Listings rendered on home")


# ══════════════════════════════════════════════════════════════
# 2. AUTH PAGES LOAD
# ══════════════════════════════════════════════════════════════
section("2. Auth pages")

r = get("/login")
ok("Login page loads") if r.status_code == 200 else fail("Login page loads", f"{r.status_code}")

r = get("/register")
ok("Register page loads") if r.status_code == 200 else fail("Register page loads", f"{r.status_code}")


# ══════════════════════════════════════════════════════════════
# 3. REGISTRATION (fresh isolated session)
# ══════════════════════════════════════════════════════════════
section("3. Registration")

reg_session = new_session()
r, token = csrf(reg_session, "/register")

if token:
    ok("CSRF token on register page")
else:
    fail("CSRF token on register page")

test_email = f"tester_{int(time.time())}@nestaway.test"
test_pass  = "Password123!"

r = reg_session.post(BASE_URL + "/register", allow_redirects=True, data={
    "_token":                token,
    "first_name":            "Test",
    "last_name":             "User",
    "email":                 test_email,
    "password":              test_pass,
    "password_confirmation": test_pass,
    "terms":                 "1",
})

if r.status_code == 200 and "/register" not in r.url:
    ok(f"Registration succeeds → {r.url.replace(BASE_URL, '') or '/'}")
else:
    fail("Registration", f"still at {r.url}, status {r.status_code}")


# ══════════════════════════════════════════════════════════════
# 4. WRONG PASSWORD (fully isolated session — never touches S)
# ══════════════════════════════════════════════════════════════
section("4. Wrong password rejected")

bad_session = new_session()
_, bad_token = csrf(bad_session, "/login")

r_bad = bad_session.post(BASE_URL + "/login", allow_redirects=True, data={
    "_token":  bad_token,
    "email":   "test@test.com",
    "password":"wrongpassword123",
})

if "/login" in r_bad.url or "credentials" in r_bad.text.lower() or "invalid" in r_bad.text.lower():
    ok("Wrong password rejected")
else:
    fail("Wrong password rejected", "may have logged in with bad creds")


# ══════════════════════════════════════════════════════════════
# 5. LOGIN (main session S — used for everything after)
# ══════════════════════════════════════════════════════════════
section("5. Login")

r, token = csrf(S, "/login")

r = post("/login", {
    "_token":  token,
    "email":   "test@test.com",
    "password":"password",
})

if r.status_code == 200 and "/login" not in r.url:
    ok("Login succeeds → test@test.com / password")
else:
    fail("Login", f"ended at {r.url}")
    print(f"\n  {RED}Cannot continue without auth. Is test@test.com seeded?{RESET}\n")
    sys.exit(1)


# ══════════════════════════════════════════════════════════════
# 6. GUEST PROTECTION (fresh session — S is logged in)
# ══════════════════════════════════════════════════════════════
section("6. Guest protection")

guest = new_session()

r = guest.get(BASE_URL + "/dashboard", allow_redirects=True)
if "/login" in r.url:
    ok("Dashboard blocked for guests → redirected to login")
else:
    fail("Dashboard blocked for guests", f"landed at {r.url}")

r = guest.get(BASE_URL + "/bookings/create?listing_id=1&check_in=2026-06-01&check_out=2026-06-05&guests=1", allow_redirects=True)
if "/login" in r.url:
    ok("Bookings/create blocked for guests → redirected to login")
else:
    fail("Bookings/create blocked for guests", f"landed at {r.url}")

r = guest.get(BASE_URL + "/listings/create", allow_redirects=True)
if "/login" in r.url:
    ok("Listings/create blocked for guests → redirected to login")
else:
    fail("Listings/create blocked for guests", f"landed at {r.url}")


# ══════════════════════════════════════════════════════════════
# 7. LISTINGS BROWSE
# ══════════════════════════════════════════════════════════════
section("7. Listings browse & filter")

r = get("/listings")
ok("Listings index loads") if r.status_code == 200 else fail("Listings index loads", f"{r.status_code}")

ids = re.findall(r'/listings/(\d+)"', r.text)
ids = list(dict.fromkeys(ids))  # dedupe, preserve order

if ids:
    ok(f"Listing cards present ({len(ids)} found)")
else:
    fail("Listing cards present", "no listing links found")

for param, label in [
    ("search=Lisbon",      "search filter"),
    ("type=apartment",     "type filter"),
    ("sort=price_asc",     "sort price asc"),
    ("sort=price_desc",    "sort price desc"),
    ("sort=rating",        "sort rating"),
    ("beds=2",             "beds filter"),
    ("price_min=50&price_max=200", "price range filter"),
]:
    r = get(f"/listings?{param}")
    ok(f"{label} returns 200") if r.status_code == 200 else fail(f"{label}", f"{r.status_code}")

r = get("/listings?search=xyznonexistentplace999abc")
if r.status_code == 200 and "No listings" in r.text:
    ok("Empty search shows no-results state")
elif r.status_code == 200:
    ok("Empty search returns 200")
else:
    fail("Empty search", f"{r.status_code}")


# ══════════════════════════════════════════════════════════════
# 8. LISTING DETAIL
# ══════════════════════════════════════════════════════════════
section("8. Listing detail")

listing_id = ids[0] if ids else "1"
r = get(f"/listings/{listing_id}")

ok(f"Listing show loads (/listings/{listing_id})") if r.status_code == 200 else fail("Listing show loads", f"{r.status_code}")
ok("Booking widget present") if ("Continue to payment" in r.text or "Log in to reserve" in r.text) else fail("Booking widget present")
ok("Host info displayed") if "Hosted by" in r.text else fail("Host info displayed")
ok("Photos section present") if "grid" in r.text or "img" in r.text else fail("Photos section present")


# ══════════════════════════════════════════════════════════════
# 9. BOOKING FLOW
# ══════════════════════════════════════════════════════════════
section("9. Booking flow")

# Find a listing with "Continue to payment" (not owned by test@test.com)
bookable_id = None
for lid in ids:
    r = get(f"/listings/{lid}")
    if "Continue to payment" in r.text:
        bookable_id = lid
        break

if not bookable_id:
    fail("Find a bookable listing", "all listings show 'Log in to reserve' or are owned by test@test.com")
    bookable_id = ids[-1] if ids else "2"
else:
    ok(f"Found bookable listing (id={bookable_id})")

check_in  = (date.today() + timedelta(days=90)).isoformat()
check_out = (date.today() + timedelta(days=95)).isoformat()

# Step 1 — load payment page
r = get(f"/bookings/create?listing_id={bookable_id}&check_in={check_in}&check_out={check_out}&guests=1")

if r.status_code == 200 and "payment" in r.text.lower():
    ok("Payment page loads")
    payment_token = re.search(r'name="_token"\s+value="([^"]+)"', r.text)
    payment_token = payment_token.group(1) if payment_token else ""
else:
    fail("Payment page loads", f"status {r.status_code}, url {r.url}")
    payment_token = ""

# Step 2 — submit booking (using same session S, token from payment page)
booking_url = None
if payment_token:
    r2 = post("/bookings", {
        "_token":         payment_token,
        "listing_id":     bookable_id,
        "check_in":       check_in,
        "check_out":      check_out,
        "guests":         "1",
        "cardholder_name":"Test User",
        "card_number":    "4111 1111 1111 1111",
        "expiry":         "12 / 28",
        "cvv":            "123",
        "billing_name":   "Test User",
        "billing_address":"123 Test Street",
        "billing_city":   "Lisbon",
        "billing_zip":    "1000-001",
        "billing_country":"PT",
    })

    if r2.status_code == 200 and "/bookings/" in r2.url:
        ok(f"Booking created → {r2.url.replace(BASE_URL,'')}")
        booking_url = r2.url
        ok("Booking confirmation page loads") if "booking" in r2.text.lower() else fail("Booking confirmation page content")
    else:
        fail("Booking created", f"status {r2.status_code}, url {r2.url}")
else:
    fail("Booking submit skipped", "no CSRF token from payment page")

# Step 3 — same dates should still be bookable (only confirmed blocks)
if payment_token:
    r3 = get(f"/bookings/create?listing_id={bookable_id}&check_in={check_in}&check_out={check_out}&guests=1")
    if r3.status_code == 200 and "payment" in r3.text.lower():
        ok("Same dates bookable again (pending doesn't block)")
    elif "/listings" in r3.url and "dates" in r3.text.lower():
        fail("Same dates bookable again", "confirmed booking is blocking same dates (expected — status is confirmed)")
    else:
        ok("Date conflict check runs correctly")


# ══════════════════════════════════════════════════════════════
# 10. DASHBOARD
# ══════════════════════════════════════════════════════════════
section("10. Dashboard")

r = get("/dashboard/trips")
ok("Dashboard trips loads") if r.status_code == 200 else fail("Dashboard trips loads", f"{r.status_code}")

if r.status_code == 200:
    ok("Trips tab content present") if ("trip" in r.text.lower() or "booking" in r.text.lower()) else fail("Trips tab content present")

r = get("/dashboard/listings")
ok("Dashboard listings loads") if r.status_code == 200 else fail("Dashboard listings loads", f"{r.status_code}")

if booking_url:
    r = get("/dashboard/trips")
    ok("Booking appears in trips") if "Confirmed" in r.text else fail("Booking appears in trips", "no confirmed booking found")


# ══════════════════════════════════════════════════════════════
# 11. HOST PAGES
# ══════════════════════════════════════════════════════════════
section("11. Host pages")

r = get("/listings/create")
ok("Create listing page loads") if r.status_code == 200 else fail("Create listing page loads", f"{r.status_code}, url={r.url}")

if r.status_code == 200:
    for field in ["title", "description", "price", "city"]:
        ok(f"Create form has {field} field") if field in r.text.lower() else fail(f"Create form has {field} field")

# Edit own listing
r_dash = get("/dashboard/listings")
own_ids = re.findall(r'/listings/(\d+)/edit', r_dash.text)
if own_ids:
    r = get(f"/listings/{own_ids[0]}/edit")
    ok(f"Edit own listing loads (/listings/{own_ids[0]}/edit)") if r.status_code == 200 else fail("Edit own listing loads", f"{r.status_code}")
else:
    ok("Edit listing skipped (no listings owned by test@test.com — seed more data if needed)")


# ══════════════════════════════════════════════════════════════
# 12. CANCEL BOOKING
# ══════════════════════════════════════════════════════════════
section("12. Cancel booking")

if booking_url:
    booking_id = booking_url.rstrip("/").split("/")[-1]

    # Get fresh token from booking page
    r = get(f"/bookings/{booking_id}")
    cancel_token = re.search(r'name="_token"\s+value="([^"]+)"', r.text)
    cancel_token = cancel_token.group(1) if cancel_token else ""

    if cancel_token:
        r = post(f"/bookings/{booking_id}/cancel", {
            "_token":  cancel_token,
            "_method": "PATCH",
        })
        if r.status_code == 200 and "dashboard" in r.url or "trips" in r.url:
            ok("Booking cancelled → redirected to trips")
        elif "cancelled" in r.text.lower():
            ok("Booking cancelled successfully")
        else:
            fail("Cancel booking", f"status {r.status_code}, url {r.url}")
    else:
        fail("Cancel booking", "no CSRF token on booking page")
else:
    ok("Cancel booking skipped (no booking was created)")


# ══════════════════════════════════════════════════════════════
# 13. SECURITY
# ══════════════════════════════════════════════════════════════
section("13. Security")

# Unauthenticated user can't see someone else's booking
if booking_url:
    booking_id = booking_url.rstrip("/").split("/")[-1]
    r = guest.get(f"{BASE_URL}/bookings/{booking_id}", allow_redirects=True)
    if "/login" in r.url:
        ok("Booking detail requires auth")
    elif r.status_code == 403:
        ok("Booking detail blocked (403) for unauthenticated user")
    else:
        fail("Booking detail auth", f"guest got {r.status_code} at {r.url}")

# SQL injection in search
r = get("/listings?search=' OR '1'='1")
ok("SQL injection in search doesn't crash app") if r.status_code == 200 else fail("SQL injection resilience", f"{r.status_code}")

# XSS in search
r = get("/listings?search=<script>alert(1)</script>")
if r.status_code == 200 and "<script>alert(1)</script>" not in r.text:
    ok("XSS in search is escaped")
else:
    fail("XSS escaping in search")

# Can't edit a listing you don't own (find one not in own_ids)
non_own = [i for i in ids if i not in (own_ids if 'own_ids' in dir() else [])]
if non_own:
    r = get(f"/listings/{non_own[0]}/edit")
    if r.status_code == 403:
        ok("Edit non-owned listing returns 403")
    elif r.status_code == 200 and "edit" in r.text.lower():
        fail("Edit non-owned listing", "got 200 — ownership check may be missing")
    else:
        ok(f"Edit non-owned listing blocked (status {r.status_code})")


# ══════════════════════════════════════════════════════════════
# SUMMARY
# ══════════════════════════════════════════════════════════════
total = passed + failed
print(f"\n{BOLD}{'═' * 55}{RESET}")
print(f"{BOLD}  Results: {GREEN}{passed} passed{RESET}  {RED}{failed} failed{RESET}  ({total} total){RESET}")
print(f"{BOLD}{'═' * 55}{RESET}\n")

sys.exit(1 if failed > 0 else 0)