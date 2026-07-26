# Online Visitor Management System — CS2001 Group Project

This is a complete starting version of your project, built with **plain PHP,
plain HTML/CSS/JavaScript, and MySQL**. No frameworks, libraries, or APIs are
used anywhere — mysqli and PHP sessions are built into PHP itself, so they
are allowed under your assignment rules.

Read this file fully before you touch anything else. It explains how to run
the project, how it is organised, and what each group member should focus on
and write about in their individual report.

---

## 1. What you need installed

You need a local server environment that gives you **PHP + MySQL + Apache**
together. The easiest option for Windows/Mac/Linux is **XAMPP**:

1. Download XAMPP: https://www.apachefriends.org/
2. Install it, then open the **XAMPP Control Panel**.
3. Click **Start** next to both **Apache** and **MySQL**.

---

## 2. Where to put the project files

1. Find your XAMPP installation folder, then open `htdocs` inside it
   (e.g. `C:\xampp\htdocs` on Windows).
2. Copy the entire `vms` folder (this folder) into `htdocs`, so you end up
   with `C:\xampp\htdocs\vms\index.php` etc.

---

## 3. Creating the database

1. With XAMPP running, open your browser and go to:
   `http://localhost/phpmyadmin`
2. Click the **SQL** tab.
3. Open the file `database.sql` (in this folder) in a text editor, copy
   **all** of its contents, paste it into the SQL box in phpMyAdmin, and
   click **Go**.
4. You should now see a new database called `visitor_management` with 4
   tables: `Users`, `Departments`, `Visitors`, `Visits`.

This script also creates:
- the compulsory default ordinary user: **uoc / uoc**
- an administrator account for testing: **admin / admin123**
- 4 sample departments

---

## 4. Running the website

Open your browser and go to:

```
http://localhost/vms/index.php
```

You should see the Login page. Try logging in with `uoc` / `uoc`, then try
`admin` / `admin123` to see the admin-only pages (Admin Dashboard, Manage
Users).

---

## 5. If something doesn't work

- **"Database connection failed"** → Open `config/db.php` and check that
  `$DB_USER`, `$DB_PASS`, and `$DB_NAME` match your XAMPP setup. By default
  XAMPP's MySQL username is `root` with an empty password, which is already
  set in the file.
- **Blank white page** → Open XAMPP's `php_error.log`, or temporarily add
  `error_reporting(E_ALL); ini_set('display_errors', 1);` at the very top of
  `index.php` to see the actual PHP error.
- **"Table doesn't exist"** → You probably haven't run `database.sql` yet
  (see step 3).

---

## 6. Project structure — what each file does

```
vms/
├── database.sql          <- run this first in phpMyAdmin
├── style.css              <- all the styling for every page
├── config/
│   └── db.php              <- the ONE place with database connection details
├── includes/
│   ├── auth_check.php       <- login/session helper functions
│   ├── header.php            <- top navigation bar (shared by every page)
│   └── footer.php            <- page footer (shared by every page)
├── index.php               <- LOGIN PAGE (first page a visitor sees)
├── login_process.php       <- checks username/password, starts the session
├── logout.php               <- ends the session
├── home.php                 <- HOME PAGE, different content if logged in
├── admin.php                 <- ADMIN PAGE with links to admin tasks
├── users.php                  <- list/search/delete users
├── add_user.php                <- add a new user
├── edit_user.php                <- edit an existing user
├── visitor.php                <- list/search visitors, delete (admin)
├── add_visitor.php             <- register a new visitor (auto check-in)
├── edit_visitor.php             <- edit visitor details
├── reports.php                <- daily & monthly visit reports, check-out
├── functionalities.php         <- FUNCTIONALITIES PAGE (static list)
└── help.php                     <- HELP PAGE (static instructions)
```

### How the login system works (important to understand for your viva)

1. `index.php` shows an HTML form that POSTs to `login_process.php`.
2. `login_process.php` looks up the username in the `Users` table using a
   **prepared statement** (`mysqli_prepare`), which protects against SQL
   Injection.
3. If the username/password match, PHP stores `user_id`, `username`,
   `role`, etc. in `$_SESSION` — a way PHP remembers who's logged in
   between page loads.
4. Every protected page starts with:
   ```php
   require_once 'includes/auth_check.php';
   requireLogin();   // or requireAdmin();
   ```
   `requireLogin()` checks `$_SESSION`; if nobody is logged in, it
   redirects back to `index.php`. This is how unauthorized users are
   blocked from admin/visitor pages, as required by the spec.
5. `logout.php` just clears `$_SESSION` and sends the user back to the
   login page.

---

## 7. Suggested split of work between your 5 group members

This maps directly onto the "Updated Project Guide" PDF you were given.

| Member | Files to focus on | What to explain in your individual report |
|---|---|---|
| **1 – Login & Authentication** | `index.php`, `login_process.php`, `logout.php`, `home.php`, `includes/auth_check.php` | How sessions work, how the default `uoc` user logs in, how unauthorized access is blocked |
| **2 – Admin & User Management** | `admin.php`, `users.php`, `add_user.php`, `edit_user.php` | The admin dashboard, how add/edit/delete/search work, role management |
| **3 – Visitor Management** | `visitor.php`, `add_visitor.php`, `edit_visitor.php` | Visitor registration flow, validation, search, linking a visitor to a department/host |
| **4 – Visit Tracking & Reports** | `reports.php`, `help.php`, `functionalities.php` | Check-in/check-out logic, how the daily/monthly report queries work, testing you did |
| **5 – Database & Integration** | `database.sql`, `config/db.php`, overall testing | The ER diagram (draw Users, Visitors, Visits, Departments and their foreign keys), all SQL queries used across the project, and how the modules connect |

Even though the code is already written for you, **do not just submit it
as-is without understanding it** — you will be asked about it in the viva.
Go through each file, and make sure every member can explain their own
section line-by-line.

---

## 8. SQL queries to include in your final report

The assignment says you must insert **all SQL queries** into your report.
Here are the important ones already in the code, which you should copy into
your report (with a short explanation of what each does):

- Login lookup (`login_process.php`)
- Insert new user (`add_user.php`)
- Update user (`edit_user.php`)
- Delete user (`users.php`)
- Insert visitor + insert visit/check-in (`add_visitor.php`)
- Update visitor (`edit_visitor.php`)
- Delete visitor (`visitor.php`)
- Update visit / check-out (`reports.php`)
- Daily report query and monthly summary query (`reports.php`)

All of these use `mysqli_prepare(...)` with `?` placeholders — that pattern
is called a **prepared statement**, and it is worth explaining in your
report why it's safer than pasting `$_POST` values directly into a SQL
string.

---

## 9. Things you should still do yourselves

This code gives you a complete, working starting point, but you should
still make it your own before submitting:

1. **Test everything** — register visitors, check them in/out, add/edit/
   delete users, try logging in as `uoc` and as `admin`.
2. **Add more validation** if you want extra marks (e.g. NIC format
   checking with plain JavaScript, which is allowed since it's not a
   framework/library).
3. **Draw your ER diagram** by hand or with a free tool based on the 4
   tables in `database.sql`.
4. **Take screenshots** of each page for your report.
5. **Style it further** if you want your own visual identity — everything
   is in `style.css`, in plain CSS.
6. Consider replacing plain-text passwords with PHP's built-in
   `password_hash()` / `password_verify()` functions as a "future
   improvement" point in your report (optional, but shows extra understanding).

Good luck with the project and the viva!
