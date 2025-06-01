# WTG Local Event Finder

Discover exciting happenings around you with this easy-to-use web app! Whether you're looking for concerts, community gatherings, or family-friendly activities, WTG Local Event Finder helps you explore and share local events in your area.

---

## 📋 Project Requirements

- **PHP** version 8.x or higher  
- **Composer** dependency manager  
- **Laravel** framework version 10.x  
- **Database**: SQLite  
- **Node.js** and **npm** for managing and building frontend assets  
- **CSS** is utilized for styling the user interface  
- **JavaScript** is used to enhance interactivity and dynamic functionality on the frontend

---

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/EdwrdEDU/WTG_Local_Event_Finder.git
   cd WTG_Local_Event_Finder
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Set up environment**
   - Copy `.env.example` to `.env`
   - Update database credentials in `.env`

4. **Generate app key**
   ```bash
   php artisan key:generate
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed the database (optional)**
   ```bash
   php artisan db:seed
   ```

7. **Build frontend assets**
   ```bash
   npm run dev
   ```

---

## ✨ Features

- 🔍 **Explore Local Events:** Effortlessly browse and search for events happening near you.
- 🗓️ **Smart Filtering:** Find events by date, category, or location to match your interests.
- 👤 **Personal Accounts:** Register and log in to unlock personalized features.
- ✏️ **Create & Manage Events:** Add, edit, or delete your own events and share them with the community.
- 📱 **Fully Responsive:** Enjoy a seamless experience on any device, from mobile to desktop.


---

## 🏃 Running the Project

Start the development server:

```bash
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000) in your browser.

---

Enjoy discovering and sharing local events!