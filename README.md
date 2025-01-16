![CleanShot 2025-01-16 at 22 35 12@2x](https://github.com/user-attachments/assets/6ec55d78-01ea-464e-af76-0b08dbe7afc0)

# Quqarecode 🐔

## Overview
This project is a web application that tracks form submissions and all events from `vue-router`. It provides insights into user interactions and navigation patterns within the app.

## Prerequisites
- Docker installed on your machine.

## What's inside?
- Clickhouse database. It's good for storing events.
- Symfony 7 websocket server.
- Vue.js frontend built with Vuetify.

## Running the Application

1. **Build the Docker Image:**
   ```bash
   docker-compose build
   ```

2. **Run the Docker Container:**
   ```bash
   docker-compose up -d
   ```

## Checking Functionality

1. **Access the Application:**
   Open your web browser and navigate to `http://localhost:8081`.

2. **Verify Event Tracking:**
   - **Form Submission:** Fill out and submit any form within the application. Check the console or network tab in your browser's developer tools to see the tracking data being sent via websocket.
   - **Vue-Router Events:** Navigate through different routes in the application. Again, use the developer tools to verify that route change events are being tracked.

## Event Tracking System
The application uses a custom event tracking system to log:
- Form submissions
- Route changes via `vue-router`

These events are logged to the console and can be configured to send data to a backend service for further analysis.

## Troubleshooting
- Ensure Docker is running and properly configured.
- Check the Docker logs for any errors:
  ```bash
  docker logs <container_id>
  ```
