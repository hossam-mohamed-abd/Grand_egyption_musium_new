# Software Requirements Specification (SRS)

## Project Overview
Grand Egyptian Museum is a PHP-based web application that provides visitors with a digital platform to explore museum collections, view events, book visits, and interact with extra services such as food options and donations. The project follows a simple MVC-style structure with routes, controllers, models, and views.

## Functional Requirements
- The system shall display a home page and public informational pages for visitors.
- The system shall allow users to register, log in, log out, and edit their profile.
- The system shall provide museum collections with a load-more endpoint for additional items.
- The system shall display events and detailed event pages by selected event ID.
- The system shall allow users to submit booking forms and donation forms.
- The system shall provide food category and item browsing pages.
- The system shall include a plans page and an admin dashboard for managing plans and user roles.

## Features

### User Authentication and Profile Management
Users can create accounts, sign in, and safely log out of the platform. They can also update profile details through dedicated profile-edit and profile-update routes.

### Museum Collections Browsing
Visitors can explore a collections section to discover museum items and highlights. A load-more API route supports progressive loading for better browsing performance.

### Events Discovery and Event Details
The platform includes an events listing page for current and upcoming activities. Each event can be opened in a detailed view using an event-specific identifier.

### Booking Submission
Users can access a booking page and submit reservation details through a booking form. This feature helps organize visitor attendance and improve museum operations.

### Donations Flow
The application provides a donation page where visitors can contribute support. Donation submissions are sent to a backend handler for processing and follow-up.

### Food and Visitor Services
A food module allows users to browse food categories and view available items. This helps visitors plan on-site services as part of their museum visit.

### Plans and Admin Management
The project includes a plans section visible to users for available offerings. An admin dashboard supports creating and deleting plans, plus updating user roles.
