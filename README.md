# Questline Bookings

A gaming-themed meeting room booking system built with PHP.

## About This Project

This project was created as part of the **CMS course** in the **Frontend Development program** at **IT-Högskolan Göteborg** (Fall 2024).

The assignment was to build a functional booking system with user authentication and server-side logic using PHP and JSON file storage.

## ✨ Features

- **Gaming-Themed Rooms** - Seven meeting rooms inspired by popular games (Zelda, Horizon Zero Dawn, Red Dead Redemption, etc.)
- **User Authentication** - Login system with "Remember me" functionality using cookies
- **Full CRUD Operations** - Create, Read, Update, Delete for users, rooms, and bookings
- **Access Control** - Protected routes with session-based authentication
- **Responsive Design** - Mobile-first approach with clean UI

## Getting Started

### Prerequisites

- PHP 8.0 or higher
- A web browser

### Installation

1. **Clone the repository**

```bash
   git clone https://github.com/yourusername/questline-bookings.git
   cd questline-bookings
```

2. **Start the PHP built-in server**

```bash
   php -S localhost:8000
```

3. **Open your browser**

   Navigate to `http://localhost:8000`

### Default Login Credentials

**Username:** `Jonny`
**Password:** `qwerty`

_(Or create a new account via the signup page)_

## 📁 Project Structure

```
questline-bookings/
├── classes/              # OOP classes
│   ├── User.php          # User entity
│   ├── Room.php          # Room entity
│   └── Booking.php       # Booking entity
├── includes/             # Reusable components
│   ├── functions.php     # Helper functions
│   ├── header.php        # Page header
│   ├── footer.php        # Page footer
│   └── check-login.php   # Authentication guard
├── data/                 # JSON data storage
│   ├── users.json        # User data
│   ├── rooms.json        # Room data
│   └── bookings.json     # Booking data
├── css/                  # Stylesheets
│   └── style.css         # Main styles
├── assets/               # Static files
│   └── images/           # Images
├── index.php             # Landing page
├── login.php             # Login page
├── signup.php            # Registration page
├── login-required.php    # Auth required message
├── dashboard.php         # User dashboard
├── rooms.php             # Room listing
├── room-booking.php      # Create booking
├── add-room.php          # Create new room
├── edit-room.php         # Edit existing room
├── users.php             # User management
├── add-user.php          # Create new user
├── edit-user.php         # Edit existing user
├── logout.php            # Logout handler
├── generate-password.php # Password hash generator
└── README.md             # Documentation
```

## Key Features Explained

### User Authentication

- Password hashing with `password_hash()` and `password_verify()`
- Session-based authentication
- "Remember me" functionality using secure cookies
- Protected routes that redirect to login

### CRUD Operations

- **Users:** Create, view, edit, and delete users
- **Rooms:** Manage meeting rooms with features (TV, Audio, Seats)
- **Bookings:** Book rooms in 2-hour slots between 08:00-20:00
- Cascade delete: Removing a user/room also removes their bookings

### Validation

- No double bookings (same room, overlapping time)
- No weekend bookings (Monday-Friday only)
- Bookings must start on the hour
- Duplicate username prevention

## Future Improvements

If I were to expand this project, I would add:

- Email notifications for booking confirmations
- Calendar view for bookings
- Archive past bookings for record-keeping
- User roles (Admin vs Regular User)
- Allow users to modify existing bookings (date, time, room)

## Linda Jensen

Frontend Development Student @ IT-Högskolan Göteborg

- Portfolio: [lindajensen-portfolio.netlify.app](https://lindajensen-portfolio.netlify.app)
- LinkedIn: [Linda Jensen](https://www.linkedin.com/in/linda-jensen-swe/)
