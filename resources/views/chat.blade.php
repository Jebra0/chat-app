@extends('layouts.app')

@section('title', 'Chats')

@section('content')
<style>
    /* Reset and Base Styles to ensure it works without Tailwind */
    :root {
        --bg-color: #000000;
        --surface-color: #121212;
        --text-primary: #FFFFFF;
        --text-secondary: #B0B3B8;
        --accent-color: #0084FF;
        --border-color: #333333;
    }

    body {
        margin: 0;
        padding: 0;
        background-color: var(--bg-color) !important;
        color: var(--text-primary) !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    .messenger-container {
        display: flex;
        flex-direction: column;
        height: 100vh;
        max-width: 600px;
        margin: 0 auto;
        background-color: var(--bg-color);
        position: relative;
    }

    /* Header */
    .header {
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        position: sticky;
        top: 0;
        background-color: rgba(0,0,0,0.8);
        backdrop-filter: blur(10px);
        z-index: 100;
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-title {
        font-size: 24px;
        font-weight: 800;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
    }

    .search-bar {
        background-color: #242526;
        border-radius: 20px;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .search-input {
        background: none;
        border: none;
        color: white;
        width: 100%;
        outline: none;
        font-size: 15px;
    }

    /* Friends Section */
    .friends-section {
        padding: 16px 0;
        overflow-x: auto;
        display: flex;
        gap: 16px;
        padding-left: 16px;
        scrollbar-width: none; /* Firefox */
    }

    .friends-section::-webkit-scrollbar {
        display: none; /* Chrome/Safari */
    }

    .friend-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        min-width: 65px;
    }

    .friend-avatar-container {
        position: relative;
        width: 56px;
        height: 56px;
    }

    .friend-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
    }

    .active-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 14px;
        height: 14px;
        background-color: #31A24C;
        border: 2px solid var(--bg-color);
        border-radius: 50%;
    }

    .friend-name {
        font-size: 12px;
        color: var(--text-secondary);
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
    }

    /* Chats Section */
    .chats-section {
        flex: 1;
        overflow-y: auto;
        padding-bottom: 80px;
    }

    .chat-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .chat-item:hover {
        background-color: #1c1c1c;
    }

    .chat-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
    }

    .chat-info {
        flex: 1;
        min-width: 0;
    }

    .chat-info-top {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2px;
    }

    .chat-name {
        font-size: 16px;
        font-weight: 600;
        margin: 0;
        color: white;
    }

    .chat-time {
        font-size: 12px;
        color: var(--text-secondary);
    }

    .chat-msg-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-msg {
        font-size: 14px;
        color: var(--text-secondary);
        margin: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .unread-dot {
        width: 10px;
        height: 10px;
        background-color: var(--accent-color);
        border-radius: 50%;
        flex-shrink: 0;
    }

    .unread .chat-msg {
        color: white;
        font-weight: 600;
    }

    /* Floating Action Button */
    .fab {
        position: fixed;
        bottom: 24px;
        right: 24px;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background-color: var(--accent-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.5);
        border: none;
        cursor: pointer;
        z-index: 1000;
    }

    /* Bottom Nav */
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60px;
        background-color: rgba(0,0,0,0.9);
        display: flex;
        justify-content: space-around;
        align-items: center;
        border-top: 1px solid var(--border-color);
        z-index: 100;
    }

    .nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 11px;
    }

    .nav-item.active {
        color: var(--accent-color);
    }

    .nav-icon {
        font-size: 20px;
    }

    /* Large Screens */
    @media (min-width: 600px) {
        .messenger-container {
            border-left: 1px solid var(--border-color);
            border-right: 1px solid var(--border-color);
        }
        .fab {
            right: calc(50% - 270px);
        }
    }
</style>

<div class="messenger-container">
    <header class="header">
        <div class="header-top">
            <h1 class="header-title">Chats</h1>
            <div class="header-actions">
                <button class="action-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
                <button class="action-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                </button>
            </div>
        </div>
        <div class="search-bar">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="#8E8E8E"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
            <input type="text" class="search-input" placeholder="Search">
        </div>
    </header>

    <div class="friends-section">
        <div class="friend-item">
            <div class="friend-avatar-container" style="background-color: #242526; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
            </div>
            <span class="friend-name">Your Story</span>
        </div>
        @php
            $friends = [
                ['name' => 'Alex', 'img' => 'https://i.pravatar.cc/100?u=1'],
                ['name' => 'Sarah', 'img' => 'https://i.pravatar.cc/100?u=2'],
                ['name' => 'John', 'img' => 'https://i.pravatar.cc/100?u=3'],
                ['name' => 'Emma', 'img' => 'https://i.pravatar.cc/100?u=4'],
                ['name' => 'Mike', 'img' => 'https://i.pravatar.cc/100?u=5'],
                ['name' => 'Sophie', 'img' => 'https://i.pravatar.cc/100?u=6'],
            ];
        @endphp
        @foreach($friends as $friend)
        <div class="friend-item">
            <div class="friend-avatar-container">
                <img src="{{ $friend['img'] }}" class="friend-avatar">
                <div class="active-indicator"></div>
            </div>
            <span class="friend-name">{{ $friend['name'] }}</span>
        </div>
        @endforeach
    </div>

    <div class="chats-section">
        @php
            $chats = [
                ['name' => 'Design Team', 'msg' => 'The new mockups are ready!', 'time' => '12:04 PM', 'img' => 'https://i.pravatar.cc/100?u=team', 'unread' => true],
                ['name' => 'Sarah Wilson', 'msg' => 'Are we still meeting today?', 'time' => '10:30 AM', 'img' => 'https://i.pravatar.cc/100?u=2', 'unread' => false],
                ['name' => 'John Doe', 'msg' => 'Check out this link!', 'time' => '9:15 AM', 'img' => 'https://i.pravatar.cc/100?u=3', 'unread' => false],
                ['name' => 'Emma Watson', 'msg' => 'Haha that was funny 😂', 'time' => 'Yesterday', 'img' => 'https://i.pravatar.cc/100?u=4', 'unread' => true],
                ['name' => 'Michael Scott', 'msg' => 'That\'s what she said!', 'time' => 'Yesterday', 'img' => 'https://i.pravatar.cc/100?u=5', 'unread' => false],
                ['name' => 'Alex Turner', 'msg' => 'I\'ll be there in 10 minutes', 'time' => 'Monday', 'img' => 'https://i.pravatar.cc/100?u=1', 'unread' => false],
                ['name' => 'Sophie B.', 'msg' => 'See you later!', 'time' => 'Monday', 'img' => 'https://i.pravatar.cc/100?u=6', 'unread' => false],
            ];
        @endphp

        @foreach($chats as $chat)
        <div class="chat-item {{ $chat['unread'] ? 'unread' : '' }}">
            <img src="{{ $chat['img'] }}" class="chat-avatar">
            <div class="chat-info">
                <div class="chat-info-top">
                    <h3 class="chat-name">{{ $chat['name'] }}</h3>
                    <span class="chat-time">{{ $chat['time'] }}</span>
                </div>
                <div class="chat-msg-container">
                    <p class="chat-msg">{{ $chat['msg'] }}</p>
                    @if($chat['unread'])
                        <div class="unread-dot"></div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <button class="fab">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
    </button>

    <nav class="bottom-nav">
        <a href="#" class="nav-item active">
            <div class="nav-icon">💬</div>
            <span>Chats</span>
        </a>
        <a href="#" class="nav-item">
            <div class="nav-icon">👥</div>
            <span>People</span>
        </a>
        <a href="#" class="nav-item">
            <div class="nav-icon">🕒</div>
            <span>Stories</span>
        </a>
    </nav>
</div>
@endsection
