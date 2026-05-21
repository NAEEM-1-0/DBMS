# Online Bookstore - XAMPP Setup Guide

## Step 1: Copy folder to XAMPP
Copy the entire `onlinebookstore` folder to:
- **Windows:** `C:\xampp\htdocs\onlinebookstore`
- **Linux:** `/opt/lampp/htdocs/onlinebookstore`

## Step 2: Import the Database
1. Open XAMPP Control Panel → Start **Apache** and **MySQL**
2. Go to: http://localhost/phpmyadmin
3. Click **"New"** → Database name: `onlinebookstore` → Create
4. Click **Import** → Choose `onlinebookstore db.sql` → Go

## Step 3: Open the Website
Go to: **http://localhost/onlinebookstore/**

## Step 4: Login
- **Admin login:** Use credentials from your Admins table (add one via phpMyAdmin if needed)
- **Customer:** Register at http://localhost/onlinebookstore/register.php

---

## Pages Reference
| URL | Description |
|-----|-------------|
| `/index.php` | Home (public) |
| `/login.php` | Login |
| `/register.php` | Register customer |
| `/adminindex.php` | Admin dashboard |
| `/customerindex.php` | Customer dashboard |
| `/books.php` | Add/Update/Delete books (admin) |
| `/search.php` | Search books (admin) |
| `/customersearch.php` | Search books (customer) |
| `/inventory.php` | Inventory (admin) |
| `/users.php` | View users (admin) |
| `/myorders.php` | Orders |
| `/myaccount.php` | My Account |

---
Converted from Python (Flask) → PHP for XAMPP compatibility.
