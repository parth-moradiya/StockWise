# StockWise Retail Solutions — Dynamic Website
**ICT726 Web Development — Assignment 4 (Dynamic Website)**
King's Own Institute | July 2025

This project extends the Assignment 3 static website for **StockWise Retail
Solutions** (a fictional company that sells retail inventory-management
software) into a full dynamic web application. The public marketing site is
now backed by a real **PHP + MySQL** demo application: visitors can register
for a free account and log in to an actual inventory dashboard — the very
product the company sells — with role-based access control.

---

## 1. Technology Stack

| Layer      | Technology |
|------------|------------|
| Markup/Styling | HTML5, CSS3 (custom, mobile-responsive, no framework) |
| Client-side scripting | Vanilla JavaScript (nav toggle, gallery lightbox, progressive-enhancement form validation) |
| Server-side | PHP 8 (procedural, PDO for database access) |
| Database | MySQL 8 / MariaDB |
| Security | `password_hash()`/`password_verify()`, CSRF tokens, prepared statements, HTTP-only session cookies, role-based access control |

No frameworks (Laravel, Bootstrap, jQuery, etc.) are used — everything is
hand-written to clearly demonstrate the underlying HTML/CSS/JS/PHP/SQL skills
required by the unit.

---

## 2. File Structure

```
retail-inventory-system/
├── index.php, about.php, features.php,        # public marketing pages
│   testimonials.php, gallery.php
├── contact.php                                 # public contact form -> DB
├── privacy.php                                 # privacy notice (Learning Outcome B)
├── register.php, login.php, logout.php         # authentication
├── dashboard.php                                # role router
├── robots.txt, sitemap.xml                      # SEO
├── admin/                                       # role = admin only
│   ├── dashboard.php        (stats overview)
│   ├── inventory.php        (list / search / delete products)
│   ├── product_form.php     (add + edit product — one form, two modes)
│   ├── users.php            (manage user roles & status)
│   └── messages.php         (view/reply-track contact enquiries)
├── staff/                                       # role = staff (+ admin), viewer read-only
│   ├── dashboard.php
│   └── inventory.php        (view stock + record stock-in/out movements)
├── config/
│   └── db.php                (PDO connection settings)
├── includes/
│   ├── functions.php         (session, CSRF, sanitisation, RBAC helpers)
│   ├── header.php            (shared <head> + nav, dynamic on login state)
│   └── footer.php            (shared footer + script includes)
├── css/
│   ├── style.css / responsive.css   (original Assignment 3 styling, kept)
│   └── app.css                       (new: dashboards, tables, alerts, badges)
├── js/
│   ├── script.js              (nav toggle + gallery lightbox)
│   └── validation.js          (generic client-side form validation)
└── sql/
    └── schema.sql              (database schema + seed/demo data)
```

---

## 3. Database Schema

Five related tables (see `sql/schema.sql` for full definitions):

- **users** — `id, full_name, email, password_hash, role(admin/staff/viewer), status, created_at`
- **categories** — `id, name`
- **products** — `id, sku, name, category_id (FK), description, price, quantity, reorder_level, image_url, created_by (FK users), timestamps`
- **stock_movements** — `id, product_id (FK), user_id (FK), movement_type(in/out), quantity, note, created_at` — a full audit trail of every stock change
- **contact_messages** — `id, full_name, email, phone, reason, message, is_read, created_at`

Relationships: `products.category_id → categories.id`,
`products.created_by → users.id`, `stock_movements.product_id → products.id`,
`stock_movements.user_id → users.id`.

---

## 4. Setup Instructions (XAMPP / WAMP / InfinityFree)

1. Create a MySQL database and import the schema:
   ```
   mysql -u root -p < sql/schema.sql
   ```
   (or use phpMyAdmin → Import → select `sql/schema.sql`)
2. Edit `config/db.php` with your database host/user/password if different
   from the defaults (`localhost` / `root` / *empty password*).
3. Copy the project folder into your server's web root (e.g. `htdocs/`) and
   browse to `index.php`.
4. **Demo accounts** (password `Passw0rd!` for all three):
   - `admin@stockwise.example` — full access (inventory CRUD, user management, messages)
   - `staff@stockwise.example` — can view inventory and record stock movements
   - `viewer@stockwise.example` — read-only inventory access
5. Anyone can also click **Sign Up** to self-register as a `staff` or `viewer`
   account (admin accounts cannot be self-registered).

---

## 5. Key Functionality Mapped to Assignment Requirements

| Requirement | Where it's implemented |
|---|---|
| Register / log in / log out | `register.php`, `login.php`, `logout.php` |
| Role-based access (admin/staff/viewer) | `includes/functions.php::require_role()`, enforced on every protected page |
| Secure password storage | `password_hash()` / `password_verify()` (bcrypt) — see `register.php`, `login.php` |
| Database CRUD via PHP | `admin/product_form.php` (Create/Update), `admin/inventory.php` (Read/Delete), `staff/inventory.php` (stock movements) |
| ≥2 validated data-entry forms | Add/Edit Product form, Record Stock Movement form, Registration form, Contact form — all validated server-side in PHP *and* client-side in `js/validation.js` |
| Semantic HTML / ARIA / accessibility | skip-link, `aria-label`, `aria-current`, `<caption class="sr-only">`, labelled form fields, keyboard-operable nav |
| Usability | consistent nav, flash messages, inline field errors, confirm dialogs on delete |
| Optimised media | `loading="lazy"` on content images |
| Privacy & ethics | `privacy.php`, no plaintext passwords, minimal data collection |
| SEO | per-page `<title>`/meta description, canonical tags, semantic heading hierarchy, `robots.txt`, `sitemap.xml`, JSON-LD structured data on the homepage |
| Security | CSRF tokens on every state-changing form, PDO prepared statements (SQL-injection safe), HTTP-only + regenerated session cookies, basic login rate-limiting |

---

## 6. Individual Contributions

*(To be completed individually by each of the three team members before
submission, per the assignment's Individual Submission requirement.)*

| Student Name | Student ID | Features / Files Contributed | Summary of Work |
|---|---|---|---|
| | | | |
| | | | |
| | | | |

---

## 7. Deviations from the Brief

None. All required functionality (authentication, role-based access,
database CRUD, ≥2 validated forms, accessibility, SEO, privacy notice) has
been implemented as specified.

---

## 8. Git Workflow

This folder should be pushed to a shared Git repository (GitHub/GitLab) with
each member committing their own features under their own account, so
progression and individual contribution are visible in the commit history,
per the assignment's mandatory Git requirement.
