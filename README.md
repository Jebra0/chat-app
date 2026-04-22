## 🚀 Overview
This project is a 1-to-1 and group messaging system. It aims to provide a seamless "no-refresh" user experience by leveraging the power of **Laravel Livewire** and **WebSockets**, while maintaining a clean, maintainable backend structure using established Design Patterns.

## 🏗️ Architecture & Design Patterns
To ensure the application is scalable and maintainable, the following patterns are implemented:

### 1. Model-View-Controller (MVC)
The fundamental architecture provided by Laravel, keeping data, logic, and presentation separated.

### 2. Gateway / Adapter Pattern
Used for the **Broadcasting System**. By using Laravel's native broadcasting contracts, the application is decoupled from the specific WebSocket provider.
* **Current Implementation:** Laravel Reverb (Self-hosted, $0 cost).
* **Future-Proof:** Can switch to Pusher or Soketi by changing a single line in the `.env` file without touching the core logic.

### 3. Repository Pattern
Data access logic for Messages and Conversations is abstracted into Repositories.
* **Benefit:** Decouples the Livewire components from Eloquent, allowing for easier unit testing and the potential to switch to NoSQL (like MongoDB) for message storage in the future.

### 4. Observer Pattern
Handled via **Laravel Events and Listeners**.
* When a message is sent, an event is dispatched.
* Separate listeners handle broadcasting to WebSockets, sending push notifications, and updating "last message" timestamps.

## 🛠️ Technology Stack
* **Framework:** Laravel 11+
* **Frontend:** Laravel Livewire (Reactive UI without leaving PHP/Blade)
* **Real-time Engine:** Laravel Reverb (WebSocket server)
* **Broadcasting Client:** Laravel Echo & Pusher-JS
* **Styling:** Tailwind CSS

The **Gateway Pattern** ensures that `broadcast(new MessageSent($message))` works identically regardless of the driver chosen.

## 📝 Key Features (Planned)
- [ ] User Authentication (Login/Register)
- [ ] Real-time message delivery (No page refresh)
- [ ] Conversation Index (List of active chats)
- [ ] Online/Offline presence indicators
- [ ] Read receipts 
