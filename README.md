# Smart Residential Society Portal

A comprehensive web application designed to manage residential societies efficiently by providing seamless operations for Admins, Residents (Owners and Renters), and Watchmen.  
Built using **PHP**, **MySQL**, **HTML**, **CSS**, and **Bootstrap**.

---

## 🏗️ Project Structure

- **Admin Panel**: Complete control over flats, allotments, user management, complaints, notices, and security staff (watchmen/maids).
- **User Panel**: Residents can view notices, make maintenance payments, register complaints, and update their profile.
- **Watchman Panel**: Manage visitor entries and track maid visits.

---

## ✨ Key Features

### Admin Panel
- **Flat Management**: Add, update, and allot flats with automatic flat-type assignment (e.g., 2BHK, 3BHK) based on floor/flat number.
- **User Management**: Approve or reject Owner and Renter registrations by verifying flat allotment.
- **Notice Board**: Post, update, and delete society notices.
- **Complaint Handling**: View, respond to, and close resident complaints.
- **Security Staff Management**:
  - Add, update, and delete watchmen details.
  - Track maid visits and visitor logs.
- **Maintenance Charges**: Automatically calculate based on flat type (1BHK/2BHK/3BHK).

### User (Resident) Panel
- **Role Selection**: Register either as an **Owner** or a **Renter**.
- **Profile Management**: Update personal information and contact details.
- **Complaint Registration**: Submit society-related complaints and track resolution status.
- **Notice Viewing**: Stay updated with important announcements.
- **Maintenance Payment**: 
  - View due charges and penalties.
  - Make payments using a secured token-based OTP verification system.
  
### Watchman Panel
- **Visitor Entry Management**: Log visitor details (name, flat visiting, in-time, out-time).
- **Maid Visit Tracking**: Mark maid check-ins and check-outs for each flat.

---

## 🔒 Security Features

- **Forgot Password**:  
  Users can securely reset passwords using token-based email verification.
  
- **OTP Verification for Payment**:  
  During maintenance payments, users receive an OTP to verify and successfully complete the transaction.

---

## 🖥️ Tech Stack

| Category         | Technologies                         |
|------------------|--------------------------------------|
| 💻 Frontend       | HTML, CSS, BootStrap                           |
| 🧠 Backend        | PHP, JS, AJAX                                  |
| 🗄 Database       | MySQL                                |
| ⚙️ Tools & IDE    | Visual Studio Code, phpMyAdmin, GitHub, XamPP |

---

## 📸 Screenshots

### 🏠 Homepage
![Homepage](https://github.com/OmAdsul/Smart_Society/blob/3b8b3e6b446f7b2da6de39c2d0c6e2cdb3d53be7/Screenshots/homepage.png)

### 🧑‍💼 Admin Dashboard
![Admin Dashboard1](https://github.com/OmAdsul/Smart_Society/blob/a9d980073e9c73c5a377993cf1e26bf29808d089/Screenshots/admin1.png)
![Admin Dashboard2](https://github.com/OmAdsul/Smart_Society/blob/a9d980073e9c73c5a377993cf1e26bf29808d089/Screenshots/admin2.png)
![Admin Dashboard3](https://github.com/OmAdsul/Smart_Society/blob/a9d980073e9c73c5a377993cf1e26bf29808d089/Screenshots/admin3.png)
![Admin Dashboard4](https://github.com/OmAdsul/Smart_Society/blob/a9d980073e9c73c5a377993cf1e26bf29808d089/Screenshots/admin4.png)

### 👮 Watchman Dashboard
![Watchman1](https://github.com/OmAdsul/Smart_Society/blob/a9d980073e9c73c5a377993cf1e26bf29808d089/Screenshots/watchman1.png)
![Watchman2](https://github.com/OmAdsul/Smart_Society/blob/a9d980073e9c73c5a377993cf1e26bf29808d089/Screenshots/watchman2.png)
![Watchman3](https://github.com/OmAdsul/Smart_Society/blob/a9d980073e9c73c5a377993cf1e26bf29808d089/Screenshots/watchman3.png)

### 👨User Dashboard
![User Dashboard1](https://github.com/OmAdsul/Smart_Society/blob/a9d980073e9c73c5a377993cf1e26bf29808d089/Screenshots/user1.png)
![User Dashboard2](https://github.com/OmAdsul/Smart_Society/blob/a9d980073e9c73c5a377993cf1e26bf29808d089/Screenshots/user2.png)
![User Dashboard3](https://github.com/OmAdsul/Smart_Society/blob/a9d980073e9c73c5a377993cf1e26bf29808d089/Screenshots/user3.png)
![User Dashboard4](https://github.com/OmAdsul/Smart_Society/blob/a9d980073e9c73c5a377993cf1e26bf29808d089/Screenshots/user4.png)

---


## 🚀 How to Run Locally

1. Clone the repository:
   ```bash
   git clone https://github.com/OmAdsul/Smart-Residential-Society-Portal.git
   ```

2. Import the SQL database:
   - Open **phpMyAdmin**.
   - Create a new database (e.g., `residential_portal`).
   - Import the provided `.sql` file.

3. Set up your server:
   - Use **XAMPP** or **WAMP** server.
   - Place the project folder in the `/htdocs` directory.

4. Update Database Configuration:
   - Edit the `db_config.php` file with your local database username and password.

5. Start the server and access:
   - Go to:  
     ```
     http://localhost/Smart-Residential-Society-Portal/
     ```

---

## 📢 Contribution

If you have suggestions for improvements or new features, feel free to fork the repository and submit a pull request!

---


