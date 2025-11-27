<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Skill;
use App\Models\Task;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks to allow truncation
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Project::truncate();
        Task::truncate();
        \Illuminate\Support\Facades\DB::table('project_skill')->truncate();
        \Illuminate\Support\Facades\DB::table('task_skill')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $projects = [
            // 1. Enterprise E-commerce (Laravel/PHP stack)
            [
                'title' => 'Enterprise E-commerce Microservices',
                'description' => 'Architect a scalable, high-performance e-commerce platform using a microservices approach. Build separate services for Product Catalog, Order Processing, and User Authentication.',
                'difficulty_level' => 'advanced',
                'skills' => ['Laravel', 'PHP', 'MySQL', 'Redis', 'Docker', 'Nuxt.js', 'Microservices', 'REST', 'gRPC', 'Kafka'],
                'tasks' => [
                    // Level 1: Setup & Basics
                    ['title' => 'Environment Setup', 'description' => 'Initialize a new Laravel project using Composer. Configure your local development environment (using Laravel Sail, Docker, or XAMPP) and update the .env file to establish a connection to your local MySQL database. Verify the setup by running the default migrations.', 'category' => 'DevOps', 'required_skills' => ['Laravel', 'PHP', 'MySQL'], 'expected_outcome' => 'A fresh Laravel installation accessible at http://localhost. The .env file should be configured with valid database credentials, and running `php artisan migrate` should succeed without errors.'],
                    ['title' => 'Database Migration', 'description' => 'Design and create database migrations for the core entities: Products (name, price, stock), Orders (user_id, total, status), and Users (name, email, password). Ensure proper data types and indexing for performance.', 'category' => 'Database', 'required_skills' => ['Laravel', 'MySQL'], 'expected_outcome' => 'The database should contain `products`, `orders`, and `users` tables with the correct columns. Verify this using a database client like phpMyAdmin or TablePlus.'],
                    ['title' => 'Basic Product API', 'description' => 'Develop a RESTful API controller for Products. Implement endpoints for listing all products (GET /api/products), showing a single product (GET /api/products/{id}), and creating a product (POST /api/products). Use Laravel Resources for JSON formatting.', 'category' => 'Backend', 'required_skills' => ['Laravel', 'PHP'], 'expected_outcome' => 'A GET request to `/api/products` returns a JSON array of product objects. A POST request to `/api/products` with valid data creates a new record in the database.'],
                    ['title' => 'Shopping Cart Service', 'description' => 'Implement a temporary shopping cart system using Redis. Create endpoints to add items to a cart, remove items, and view the current cart. The cart data should expire after a set duration.', 'category' => 'Backend', 'required_skills' => ['Laravel', 'Redis'], 'expected_outcome' => 'Redis should contain cart data. Hitting the `/api/cart` endpoint returns the current items. Adding an item updates the Redis key for that user session.'],
                    ['title' => 'Payment Gateway Integration', 'description' => 'Integrate a mock payment gateway service (or use Stripe Test mode). Create a service class that handles the payment processing logic and returns a success or failure response. Ensure payment attempts are logged.', 'category' => 'Backend', 'required_skills' => ['Laravel', 'PHP'], 'expected_outcome' => 'The API returns a 200 OK status with a transaction ID upon successful payment. The application logs should show "Payment processed for Order #123".'],
                    ['title' => 'Email Notification Service', 'description' => 'Set up a Laravel Queue worker to handle background jobs. Create a Job class that sends an order confirmation email to the user after a successful checkout. Configure the queue driver to use Redis or Database.', 'category' => 'Backend', 'required_skills' => ['Laravel', 'Redis'], 'expected_outcome' => 'After placing an order, a job is pushed to the Redis queue. The `jobs` table (or Redis) shows the pending job, and running `php artisan queue:work` processes it.'],

                    // Level 2: Intermediate Features
                    ['title' => 'User Authentication', 'description' => 'Implement secure API authentication using Laravel Sanctum or JWT. Protect the order placement and user profile endpoints so only authenticated users can access them. Implement login and registration controllers.', 'category' => 'Security', 'required_skills' => ['Laravel', 'REST'], 'expected_outcome' => 'Requests to protected endpoints without a valid Bearer token return 401 Unauthorized. Successful login returns a valid token.'],
                    ['title' => 'Product Catalog Service', 'description' => 'Refactor the Product API into a dedicated service. Implement caching using Redis to store the product list for faster retrieval. Ensure the cache is invalidated or updated when a product is modified.', 'category' => 'Backend', 'required_skills' => ['Laravel', 'MySQL', 'Redis', 'REST'], 'expected_outcome' => 'First request hits the DB, subsequent requests hit Redis (check Redis keys). Updating a product clears the cache.'],
                    ['title' => 'Admin Dashboard API', 'description' => 'Create a set of administrative API endpoints for managing products and orders. Implement Middleware to ensure only users with an "admin" role can access these routes.', 'category' => 'Backend', 'required_skills' => ['Laravel', 'PHP'], 'expected_outcome' => 'Accessing `/api/admin/*` as a normal user returns 403 Forbidden. Admin users can access CRUD operations.'],
                    ['title' => 'Search Service', 'description' => 'Implement full-text search capabilities for the product catalog. Use Laravel Scout with a driver like Meilisearch or Algolia (or a basic database driver) to allow users to search products by name or description.', 'category' => 'Backend', 'required_skills' => ['Laravel', 'MySQL'], 'expected_outcome' => 'Searching for "Laptop" returns relevant product results quickly, even with a large dataset.'],
                    ['title' => 'Inventory Management', 'description' => 'Implement logic to handle stock deduction when an order is placed. Use database transactions and locking (pessimistic or optimistic) to prevent race conditions where two users buy the last item simultaneously.', 'category' => 'Backend', 'required_skills' => ['Laravel', 'MySQL'], 'expected_outcome' => 'Simultaneous requests for the last item result in only one successful order. Stock count never goes below zero.'],
                    ['title' => 'API Gateway Implementation', 'description' => 'Set up a simple API Gateway (using a proxy or a dedicated tool like Kong or a Laravel wrapper) that routes incoming requests to the appropriate microservices (Product Service, Order Service, Auth Service).', 'category' => 'DevOps', 'required_skills' => ['Microservices', 'REST'], 'expected_outcome' => 'All requests go through a single port (e.g., 8000) and are correctly routed to backend services (e.g., 8001, 8002).'],

                    // Level 3: Advanced Architecture
                    ['title' => 'Service Architecture Design', 'description' => 'Draft a comprehensive architecture document detailing how the microservices communicate. Define the API contracts (using OpenAPI/Swagger) and choose a communication protocol (REST vs gRPC).', 'category' => 'System Design', 'required_skills' => ['Microservices', 'Docker', 'REST', 'gRPC'], 'expected_outcome' => 'A `docker-compose.yml` file defining all services and a `swagger.yaml` file documenting the API endpoints.'],
                    ['title' => 'Order Management Service', 'description' => 'Decouple the Order logic into its own microservice. Use an event-driven approach where the Order Service listens for "PaymentSuccessful" events via Kafka or RabbitMQ to trigger order creation.', 'category' => 'Backend', 'required_skills' => ['PHP', 'MySQL', 'Kafka'], 'expected_outcome' => 'Publishing a message to the "payments" topic triggers the Order Service to create a new order record.'],
                    ['title' => 'Centralized Logging', 'description' => 'Implement a centralized logging strategy. Configure all microservices to ship their logs to an ELK (Elasticsearch, Logstash, Kibana) stack or a similar solution to view logs in one place.', 'category' => 'DevOps', 'required_skills' => ['Docker', 'Microservices'], 'expected_outcome' => 'Logs from all containers are visible in the Kibana dashboard, searchable by service name.'],
                    ['title' => 'Monitoring & Metrics', 'description' => 'Instrument your applications to expose metrics (CPU, memory, request count). Set up Prometheus to scrape these metrics and Grafana to visualize them in a dashboard.', 'category' => 'DevOps', 'required_skills' => ['Docker', 'Microservices'], 'expected_outcome' => 'A Grafana dashboard showing real-time graphs of request latency and error rates.'],
                    ['title' => 'CI/CD Pipeline Setup', 'description' => 'Create a CI/CD pipeline using GitHub Actions or GitLab CI. The pipeline should automatically run unit tests (PHPUnit) and style checks whenever code is pushed to the repository.', 'category' => 'DevOps', 'required_skills' => ['Docker'], 'expected_outcome' => 'Pushing code triggers a GitHub Action workflow that passes (green checkmark) only if tests pass.'],
                    ['title' => 'Load Testing & Optimization', 'description' => 'Perform load testing using tools like JMeter or k6. Simulate high traffic to the API Gateway and identify bottlenecks. Optimize database queries and cache configurations based on the results.', 'category' => 'DevOps', 'required_skills' => ['PHP', 'MySQL'], 'expected_outcome' => 'A report showing the max requests per second (RPS) the system can handle before and after optimization.'],
                ]
            ],
            // 2. Real-time Collaboration (React/Node stack)
            [
                'title' => 'Real-time Collaboration Platform',
                'description' => 'Develop a Slack-like communication tool supporting channels and direct messages. Focus on WebSockets and event-driven architecture.',
                'difficulty_level' => 'advanced',
                'skills' => ['React', 'Node.js', 'NestJS', 'MongoDB', 'Redux', 'Event-Driven Architecture', 'RabbitMQ'],
                'tasks' => [
                    // Level 1: Setup & Basics
                    ['title' => 'Frontend Setup', 'description' => 'Initialize a new React application using Create React App or Vite. Set up the basic folder structure and install necessary dependencies like React Router and a CSS framework (e.g., Tailwind or Material UI).', 'category' => 'Frontend', 'required_skills' => ['React', 'JavaScript'], 'expected_outcome' => 'A React application running on localhost:3000. The browser console should show no errors, and the main page should display a "Welcome to Chat" header.'],
                    ['title' => 'Static Chat UI', 'description' => 'Design and build the chat interface components (Sidebar, Chat Window, Message Input) using mock data. Ensure the layout is responsive and the message list scrolls correctly.', 'category' => 'Frontend', 'required_skills' => ['React', 'CSS'], 'expected_outcome' => 'A responsive chat interface with a sidebar for channels and a main area for messages. Message bubbles should align left for received and right for sent messages.'],
                    ['title' => 'Node.js API', 'description' => 'Create a basic backend API using Express or NestJS. Implement a POST /login endpoint that accepts a username and returns a JWT token. Set up a simple in-memory or database user store.', 'category' => 'Backend', 'required_skills' => ['Node.js'], 'expected_outcome' => 'A Node.js server running on port 5000. Sending a POST request to `/login` with valid credentials returns a JSON object containing a JWT access token.'],
                    ['title' => 'User Presence', 'description' => 'Implement real-time user presence using Socket.io. When a user connects, broadcast their "online" status to other connected clients. Update the UI to show a green dot next to online users.', 'category' => 'Backend', 'required_skills' => ['Node.js', 'React'], 'expected_outcome' => 'When a second browser tab is opened, the first tab should immediately show the new user as "Online" (e.g., a green dot). Closing the tab changes the status to "Offline".'],
                    ['title' => 'Typing Indicators', 'description' => 'Add a "User is typing..." feature. Emit a socket event when the user types in the input box, and display a typing indicator on the receiving client\'s screen.', 'category' => 'Frontend', 'required_skills' => ['React', 'Node.js'], 'expected_outcome' => 'When typing in one client, the other client displays a "User is typing..." indicator. The indicator disappears 2 seconds after typing stops.'],
                    ['title' => 'Message History Persistence', 'description' => 'Connect the backend to a MongoDB database. Create a Mongoose schema for Messages and save every chat message to the database. Create an endpoint to fetch chat history on load.', 'category' => 'Database', 'required_skills' => ['MongoDB', 'Node.js'], 'expected_outcome' => 'Refreshing the browser page loads previous messages from the MongoDB database. The messages should appear in the correct chronological order.'],

                    // Level 2: Intermediate Features
                    ['title' => 'Chat UI Component', 'description' => 'Refactor the chat state management using Redux or Context API. Ensure that incoming socket messages update the global state and re-render the message list component efficiently.', 'category' => 'Frontend', 'required_skills' => ['React', 'Redux'], 'expected_outcome' => 'The Redux DevTools show actions being dispatched when messages arrive. The UI updates without a full page reload.'],
                    ['title' => 'File Sharing Support', 'description' => 'Implement file upload functionality. Allow users to select an image or file, upload it to the server (or cloud storage), and send the file URL as a message attachment.', 'category' => 'Backend', 'required_skills' => ['Node.js', 'React'], 'expected_outcome' => 'Uploading an image displays it in the chat window. Clicking the image opens it in a new tab.'],
                    ['title' => 'Group Channels', 'description' => 'Extend the data model to support Channels. Create API endpoints to create a channel, join a channel, and list available channels. Update the socket logic to broadcast messages only to users in the specific channel room.', 'category' => 'Backend', 'required_skills' => ['Node.js', 'MongoDB'], 'expected_outcome' => 'Messages sent in "General" channel do not appear in "Random" channel. Users can switch between channels via the sidebar.'],
                    ['title' => 'Push Notifications', 'description' => 'Implement browser push notifications using the Web Push API or a library. Request permission from the user and trigger a notification when a new message arrives while the tab is in the background.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'Receiving a message while the tab is minimized triggers a system notification (toast) on the OS.'],
                    ['title' => 'Voice/Video Call Integration', 'description' => 'Integrate WebRTC to allow peer-to-peer voice or video calls. Implement the signaling logic using your existing WebSocket server to exchange SDP offers and answers.', 'category' => 'Frontend', 'required_skills' => ['React', 'JavaScript'], 'expected_outcome' => 'Two users can establish a video call. Local and remote video streams are visible.'],
                    ['title' => 'Message Encryption', 'description' => 'Implement End-to-End encryption for private messages. Generate key pairs in the browser and encrypt the message payload before sending it to the server, so the server cannot read the content.', 'category' => 'Security', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Intercepting the network request shows encrypted gibberish in the payload. The recipient client successfully decrypts and displays the text.'],

                    // Level 3: Advanced Architecture
                    ['title' => 'WebSocket Server Setup', 'description' => 'Refactor the WebSocket server for scalability. Use a dedicated NestJS Gateway or a separate microservice for handling socket connections, ensuring it can handle thousands of concurrent users.', 'category' => 'Backend', 'required_skills' => ['Node.js', 'NestJS', 'Event-Driven Architecture'], 'expected_outcome' => 'The socket server runs as a standalone process. Connecting 1000 simulated clients works without crashing.'],
                    ['title' => 'Message Queue Integration', 'description' => 'Decouple message processing using RabbitMQ. When a message is sent, publish it to a queue. Have a worker service consume the queue to persist the message to the database.', 'category' => 'Backend', 'required_skills' => ['RabbitMQ', 'Node.js'], 'expected_outcome' => 'Messages are delivered instantly to clients, but database writes happen asynchronously via the worker.'],
                    ['title' => 'User Profile Management', 'description' => 'Create a user profile page where users can update their display name, avatar, and status message. Ensure these updates are reflected in real-time across all connected clients.', 'category' => 'Frontend', 'required_skills' => ['React', 'Node.js'], 'expected_outcome' => 'Changing the avatar in one tab immediately updates the avatar icon in all other users\' chat views.'],
                    ['title' => 'Search Messages', 'description' => 'Implement a search feature for chat history. Use MongoDB text search or an external search engine to allow users to find past messages by keyword.', 'category' => 'Database', 'required_skills' => ['MongoDB'], 'expected_outcome' => 'Searching for a keyword returns a list of matching messages with timestamps.'],
                    ['title' => 'Scalability: Redis Adapter', 'description' => 'Configure the Socket.io Redis Adapter. This allows you to run multiple instances of your socket server and have them communicate, ensuring messages reach users connected to different server nodes.', 'category' => 'Backend', 'required_skills' => ['Node.js', 'Redis'], 'expected_outcome' => 'Users connected to Server Instance A can chat with users connected to Server Instance B.'],
                    ['title' => 'Deployment to Kubernetes', 'description' => 'Containerize the application and deploy it to a Kubernetes cluster. Create deployment and service manifests, and set up an Ingress controller for external access.', 'category' => 'DevOps', 'required_skills' => ['Docker'], 'expected_outcome' => '`kubectl get pods` shows running pods for frontend, backend, and database. The app is accessible via a public IP.'],
                ]
            ],
            // 3. AI Image Classifier (Python/AI stack)
            [
                'title' => 'AI-Powered Image Classifier',
                'description' => 'Build a web application that can classify images uploaded by users. Train a model and deploy it via a FastAPI service.',
                'difficulty_level' => 'advanced',
                'skills' => ['Python', 'TensorFlow', 'FastAPI', 'React', 'OpenCV', 'Deep Learning', 'REST'],
                'tasks' => [
                    // Level 1: Setup & Basics
                    ['title' => 'Project Structure', 'description' => 'Set up the Python environment using venv or conda. Create a `requirements.txt` file with necessary libraries (FastAPI, uvicorn, opencv-python, tensorflow). Initialize a Git repository.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'A python virtual environment is active. Running `pip freeze` lists FastAPI, uvicorn, opencv-python, and tensorflow.'],
                    ['title' => 'Basic Scripting', 'description' => 'Write a Python script using OpenCV to read an image file from disk and display it in a window. This verifies that your image processing libraries are correctly installed.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'OpenCV'], 'expected_outcome' => 'Running `python read_image.py` opens a window displaying the test image. The console prints the image dimensions (e.g., "Image shape: (1920, 1080, 3)").'],
                    ['title' => 'Image Preprocessing', 'description' => 'Create a function to preprocess images for the model. This should include resizing the image to a fixed size (e.g., 224x224) and normalizing pixel values to be between 0 and 1.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'OpenCV'], 'expected_outcome' => 'The script outputs a processed image array. The shape should be (224, 224, 3) and pixel values should be floats between 0.0 and 1.0.'],
                    ['title' => 'Simple API', 'description' => 'Create a basic FastAPI application with a single GET / endpoint that returns a JSON "Hello World" message. Run the server using Uvicorn to ensure it works.', 'category' => 'Backend', 'required_skills' => ['FastAPI', 'Python'], 'expected_outcome' => 'Visiting `http://localhost:8000/` in the browser displays `{"message": "Hello World"}`. The Swagger UI is accessible at `/docs`.'],
                    ['title' => 'Data Augmentation Pipeline', 'description' => 'Implement a data augmentation pipeline using TensorFlow or Keras. Generate new training samples by applying random rotations, flips, and zooms to your existing dataset.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'TensorFlow'], 'expected_outcome' => 'The script saves 5 new versions of the input image to an `augmented/` folder, each with different transformations (rotation, flip, zoom).'],
                    ['title' => 'Model Evaluation Metrics', 'description' => 'Write a script to calculate evaluation metrics. Given a set of true labels and predicted labels, compute the Accuracy, Precision, Recall, and F1-score.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'Scikit-learn'], 'expected_outcome' => 'The script prints a classification report to the console showing Precision, Recall, and F1-score for each class, along with the overall accuracy.'],

                    // Level 2: Intermediate Features
                    ['title' => 'Model Training', 'description' => 'Train a Convolutional Neural Network (CNN) on a standard dataset (like CIFAR-10 or MNIST). Save the trained model to an .h5 or .keras file once it achieves a satisfactory accuracy (>85%).', 'category' => 'AI/Data', 'required_skills' => ['Python', 'TensorFlow', 'Deep Learning'], 'expected_outcome' => 'A `model.h5` file is created. The training logs show validation accuracy exceeding 85%.'],
                    ['title' => 'Prediction API', 'description' => 'Create a POST /predict endpoint in FastAPI. This endpoint should accept an image file upload, preprocess it using your function, run it through the trained model, and return the predicted class.', 'category' => 'Backend', 'required_skills' => ['FastAPI', 'Python', 'REST'], 'expected_outcome' => 'Sending a POST request with an image of a cat returns `{"class": "cat", "confidence": 0.98}`.'],
                    ['title' => 'Hyperparameter Tuning', 'description' => 'Experiment with different hyperparameters (learning rate, batch size, number of layers) to improve model performance. Log the results of each run to compare them.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'TensorFlow'], 'expected_outcome' => 'A CSV file or TensorBoard log containing comparison data of at least 3 different model configurations.'],
                    ['title' => 'Model Versioning', 'description' => 'Implement a system to manage model versions. Allow the API to load a specific version of the model based on a configuration file or environment variable.', 'category' => 'DevOps', 'required_skills' => ['Python'], 'expected_outcome' => 'Setting `MODEL_VERSION=v1` loads `model_v1.h5`. Changing it to `v2` loads `model_v2.h5` without code changes.'],
                    ['title' => 'Batch Prediction Endpoint', 'description' => 'Add support for batch predictions. Create an endpoint that accepts a list of images (or a zip file) and returns predictions for all of them in a single response.', 'category' => 'Backend', 'required_skills' => ['FastAPI', 'Python'], 'expected_outcome' => 'Uploading a zip file with 10 images returns a JSON array with 10 prediction objects.'],
                    ['title' => 'Frontend Image Upload UI', 'description' => 'Build a simple React frontend that allows users to drag and drop an image. On drop, send the image to your FastAPI backend and display the returned prediction result.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'A web page with a drop zone. Dropping an image displays a loading spinner, then the prediction result text.'],

                    // Level 3: Advanced Architecture
                    ['title' => 'Result Visualization', 'description' => 'Enhance the frontend to visualize the model\'s confidence scores. Use a charting library (like Recharts or D3.js) to show a bar chart of probabilities for the top 5 classes.', 'category' => 'Frontend', 'required_skills' => ['React', 'D3.js'], 'expected_outcome' => 'The UI displays a bar chart where the X-axis is the class name and Y-axis is the probability.'],
                    ['title' => 'User Feedback Loop', 'description' => 'Add a mechanism for users to correct the model. If the prediction is wrong, allow the user to submit the correct label, and save this data to a database for future retraining.', 'category' => 'Backend', 'required_skills' => ['FastAPI', 'Database'], 'expected_outcome' => 'Clicking "Incorrect" and selecting the right label saves a record in the `feedback` table with the image path and user correction.'],
                    ['title' => 'Dockerize Model Service', 'description' => 'Create a Dockerfile for the FastAPI application. Ensure it installs all dependencies and exposes the correct port. Build and run the container locally.', 'category' => 'DevOps', 'required_skills' => ['Docker'], 'expected_outcome' => 'Running `docker run -p 8000:8000 my-model-service` makes the API accessible at localhost:8000.'],
                    ['title' => 'GPU Acceleration Setup', 'description' => 'Configure your training environment to use a GPU (if available) or Google Colab. Ensure TensorFlow is using the CUDA libraries for faster training.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'TensorFlow'], 'expected_outcome' => '`tf.config.list_physical_devices(\'GPU\')` returns a non-empty list. Training time is significantly reduced.'],
                    ['title' => 'API Rate Limiting', 'description' => 'Implement rate limiting on your API using Redis or a middleware. Limit users to a certain number of prediction requests per minute to prevent abuse.', 'category' => 'Backend', 'required_skills' => ['FastAPI', 'Redis'], 'expected_outcome' => 'Sending more than 60 requests in a minute results in a 429 Too Many Requests response.'],
                    ['title' => 'Model Monitoring', 'description' => 'Set up a monitoring script to track the distribution of predicted classes over time. Alert if the distribution shifts significantly (data drift).', 'category' => 'AI/Data', 'required_skills' => ['Python'], 'expected_outcome' => 'A dashboard or log file showing the percentage of predictions for each class over the last hour.'],
                ]
            ],
            // 4. Cross-Platform Fitness App (Mobile stack)
            [
                'title' => 'Cross-Platform Fitness Tracker',
                'description' => 'Create a mobile app to track workouts and diet. Use React Native for cross-platform compatibility and Firebase for the backend.',
                'difficulty_level' => 'intermediate',
                'skills' => ['React Native', 'Firebase', 'TypeScript', 'JavaScript', 'OAuth2'],
                'tasks' => [
                    ['title' => 'UI Mockups', 'description' => 'Design the app screens (Login, Dashboard, Workout Log, Profile) using Figma or Sketch. Then, convert these designs into HTML/CSS mockups or directly into React Native components to verify the layout.', 'category' => 'Frontend', 'required_skills' => ['JavaScript', 'CSS'], 'expected_outcome' => 'A set of HTML files or React Native components that visually match the design. Navigation between the Login and Dashboard screens should work visually.'],
                    ['title' => 'App Navigation', 'description' => 'Set up the navigation structure using React Navigation. Implement a Bottom Tab Navigator for the main sections and a Stack Navigator for drilling down into details (e.g., Workout Details).', 'category' => 'Mobile', 'required_skills' => ['React Native', 'TypeScript'], 'expected_outcome' => 'Tapping the "Workout" tab switches the view to the Workout screen. The "Back" button in the stack navigator correctly returns to the previous screen.'],
                    ['title' => 'User Authentication', 'description' => 'Integrate Firebase Authentication. Allow users to sign up and log in using their email and password. Optionally, add Google Sign-In for easier access.', 'category' => 'Backend', 'required_skills' => ['Firebase', 'OAuth2'], 'expected_outcome' => 'Users can sign up with an email/password. The Firebase Console > Authentication tab shows the new user record. The app redirects to the Dashboard upon success.'],
                    ['title' => 'Workout Logging', 'description' => 'Create a form to log a workout session. Users should be able to add exercises, specify sets, reps, and weight. Store this data in Firestore under the user\'s ID.', 'category' => 'Mobile', 'required_skills' => ['React Native', 'JavaScript'], 'expected_outcome' => 'Submitting the form adds a new document to the `workouts` collection in Firestore. The data includes the correct timestamp and exercise details.'],
                    ['title' => 'Exercise Database', 'description' => 'Populate a Firestore collection with a list of common exercises (e.g., Bench Press, Squat). Implement a search bar in the logging screen to allow users to find and select exercises.', 'category' => 'Database', 'required_skills' => ['Firebase'], 'expected_outcome' => 'Typing "Bench" in the search bar filters the list to show "Bench Press". Selecting it populates the exercise name field.'],
                    ['title' => 'Progress Charts', 'description' => 'Visualize the user\'s progress over time. Use a charting library (like react-native-chart-kit) to display a line graph of the max weight lifted for a specific exercise.', 'category' => 'Frontend', 'required_skills' => ['React Native'], 'expected_outcome' => 'The chart correctly renders data points from Firestore. The X-axis shows dates and the Y-axis shows weight lifted.'],
                    ['title' => 'Profile Settings', 'description' => 'Create a settings screen where users can update their profile information (height, weight) and preferences (units: kg/lbs). Save these preferences to Firestore.', 'category' => 'Frontend', 'required_skills' => ['React Native'], 'expected_outcome' => 'Changing the unit preference to "lbs" immediately updates the weight display on the Dashboard.'],
                    ['title' => 'Offline Support', 'description' => 'Enable offline persistence in Firebase. Ensure that users can still view their history and log new workouts even when they don\'t have an internet connection, syncing when they reconnect.', 'category' => 'Mobile', 'required_skills' => ['React Native'], 'expected_outcome' => 'Turning off Wi-Fi/Data and logging a workout still works. Reconnecting to the internet causes the new data to appear in the Firebase Console.'],
                    ['title' => 'Social Sharing', 'description' => 'Implement a "Share" feature. Generate a summary image or text of a completed workout and allow the user to share it to Instagram, Twitter, or other apps using the native share sheet.', 'category' => 'Mobile', 'required_skills' => ['React Native'], 'expected_outcome' => 'Tapping "Share" opens the OS share dialog. Selecting "Messages" pre-fills the text with "I just lifted 100kg on Bench Press!".'],
                    ['title' => 'Push Notifications', 'description' => 'Configure local push notifications. Schedule a notification to remind the user to work out if they haven\'t logged activity for a few days.', 'category' => 'Mobile', 'required_skills' => ['Firebase'], 'expected_outcome' => 'A notification appears on the device simulator after the scheduled time, even if the app is closed.'],
                    ['title' => 'Dark Mode Support', 'description' => 'Implement a dark mode theme. Use the React Native Appearance API to detect the system theme and switch the app\'s colors accordingly.', 'category' => 'Frontend', 'required_skills' => ['React Native', 'CSS'], 'expected_outcome' => 'Toggling the system-wide Dark Mode setting automatically updates the app\'s background to black and text to white.'],
                    ['title' => 'App Store Deployment Prep', 'description' => 'Prepare the app for release. Configure the app icon and splash screen. Generate a signed APK (Android) or Archive (iOS) for testing on a physical device.', 'category' => 'DevOps', 'required_skills' => ['React Native'], 'expected_outcome' => 'A `.apk` file is generated. Installing it on a phone shows the correct custom app icon.'],
                ]
            ],
            // 5. Secure Banking API (Go/Security stack)
            [
                'title' => 'Secure Banking API',
                'description' => 'Design a high-security API for financial transactions. Focus on concurrency, data integrity, and secure coding practices.',
                'difficulty_level' => 'advanced',
                'skills' => ['Go', 'PostgreSQL', 'Docker', 'Linux', 'Symfony', 'OAuth2', 'JWT', 'gRPC'],
                'tasks' => [
                    ['title' => 'Database Schema', 'description' => 'Design a normalized database schema for a banking system. Create tables for Users, Accounts, and Transfers. Ensure you use appropriate data types (e.g., BIGINT for currency in cents) and foreign key constraints.', 'category' => 'Database', 'required_skills' => ['MySQL'], 'expected_outcome' => 'The PostgreSQL database contains `users`, `accounts`, and `transactions` tables. Foreign keys enforce referential integrity (e.g., a transaction cannot reference a non-existent account).'],
                    ['title' => 'Transaction Service', 'description' => 'Implement the core money transfer logic using Go. Ensure that transfers are atomic: use database transactions to deduct from one account and credit another. Rollback if any step fails.', 'category' => 'Backend', 'required_skills' => ['Go', 'PostgreSQL', 'gRPC'], 'expected_outcome' => 'Calling the Transfer RPC moves funds between accounts. If the sender has insufficient funds, the transaction fails and no money is deducted.'],
                    ['title' => 'Security Layer', 'description' => 'Implement OAuth2 authentication with JWT. Create middleware to validate tokens on every request. Ensure that users can only access their own accounts (IDOR protection).', 'category' => 'Security', 'required_skills' => ['OAuth2', 'JWT'], 'expected_outcome' => 'Requests without a valid Bearer token return a 401 Unauthorized status. Requests with a token for User A cannot access User B\'s account details.'],
                    ['title' => 'Containerization', 'description' => 'Create a multi-stage Dockerfile for the Go application. Use a minimal base image (like Alpine) for the final stage to reduce the attack surface. Configure the container to run as a non-root user.', 'category' => 'DevOps', 'required_skills' => ['Docker', 'Linux'], 'expected_outcome' => 'Running `docker run banking-api` starts the service. The container image size is under 50MB (using Alpine/Scratch) and runs as a non-root user.'],
                    ['title' => 'Account Management API', 'description' => 'Create REST endpoints for creating new accounts, listing accounts, and viewing account details. Validate all inputs strictly to prevent injection attacks.', 'category' => 'Backend', 'required_skills' => ['Go', 'PostgreSQL'], 'expected_outcome' => 'POST /accounts creates a new account. GET /accounts/{id} returns the account balance. Input validation prevents negative initial balances.'],
                    ['title' => 'Audit Logging', 'description' => 'Implement an immutable audit log. Every time a transaction occurs or a setting is changed, write a record to a separate "Audit" table or service. This log should never be deletable.', 'category' => 'Security', 'required_skills' => ['Go'], 'expected_outcome' => 'Every API request results in a new row in the `audit_logs` table, recording the User ID, Action, Timestamp, and IP address.'],
                    ['title' => 'Rate Limiting', 'description' => 'Implement a Token Bucket or Leaky Bucket algorithm to rate limit API requests. This prevents brute-force attacks and Denial of Service (DoS) attempts.', 'category' => 'Security', 'required_skills' => ['Go', 'Redis'], 'expected_outcome' => 'Sending requests faster than the limit (e.g., 10 req/sec) results in a 429 Too Many Requests response.'],
                    ['title' => 'Two-Factor Authentication', 'description' => 'Add 2FA support using TOTP (Time-based One-Time Password). Generate a QR code for the user to scan with Google Authenticator, and require the code for sensitive actions.', 'category' => 'Security', 'required_skills' => ['Go'], 'expected_outcome' => 'Scanning the QR code with Google Authenticator adds the account. Entering the generated 6-digit code successfully verifies the user.'],
                    ['title' => 'Fraud Detection Rules', 'description' => 'Implement a background worker that analyzes transactions. Flag any transaction that exceeds a certain amount or occurs from a suspicious IP address for manual review.', 'category' => 'Backend', 'required_skills' => ['Go'], 'expected_outcome' => 'A transaction of $10,000 triggers a "Review Needed" flag in the database and sends an alert to the admin channel.'],
                    ['title' => 'Currency Conversion Service', 'description' => 'Integrate with an external currency exchange API. Allow users to transfer money between accounts with different currencies, calculating the exchange rate in real-time.', 'category' => 'Backend', 'required_skills' => ['Go'], 'expected_outcome' => 'Transferring 100 USD to a EUR account credits the correct amount based on the current exchange rate.'],
                    ['title' => 'API Documentation', 'description' => 'Use Swagger/OpenAPI to document your API endpoints. Include details about request parameters, response formats, and error codes. Host the documentation on a public URL.', 'category' => 'Backend', 'required_skills' => ['Go'], 'expected_outcome' => 'A Swagger UI page is accessible at `/swagger/index.html`, allowing users to test the API endpoints directly.'],
                    ['title' => 'Integration Testing', 'description' => 'Write integration tests that spin up a test database and run full transaction scenarios. Verify that balances are updated correctly and that invalid transactions are rejected.', 'category' => 'DevOps', 'required_skills' => ['Go'], 'expected_outcome' => 'Running `go test ./...` executes the integration tests against a Dockerized Postgres instance and passes.'],
                    ['title' => 'Secret Management', 'description' => 'Remove all hardcoded credentials from the code. Use environment variables or a secret management tool (like HashiCorp Vault) to inject database passwords and API keys at runtime.', 'category' => 'Security', 'required_skills' => ['Linux'], 'expected_outcome' => 'The codebase contains no passwords. The application fails to start if the `DB_PASSWORD` environment variable is missing.'],
                    ['title' => 'Mutual TLS', 'description' => 'Configure Mutual TLS (mTLS) for communication between your microservices. This ensures that only authorized services can talk to each other.', 'category' => 'Security', 'required_skills' => ['Go'], 'expected_outcome' => 'Services communicate over HTTPS with client certificates. A service without a valid certificate is rejected.'],
                    ['title' => 'Database Replication', 'description' => 'Set up PostgreSQL streaming replication. Configure a primary database for writes and a read replica for read-heavy operations (like viewing transaction history).', 'category' => 'Database', 'required_skills' => ['PostgreSQL'], 'expected_outcome' => 'Data written to the Primary DB appears in the Replica DB within seconds. The application reads from the Replica.'],
                    ['title' => 'Kubernetes Deployment', 'description' => 'Create Helm charts to deploy your application to a Kubernetes cluster. Define resources (CPU/Memory limits) and configure liveness/readiness probes.', 'category' => 'DevOps', 'required_skills' => ['Kubernetes'], 'expected_outcome' => '`helm install banking-app ./charts` deploys the application. Pods restart automatically if they become unresponsive.'],
                    ['title' => 'Vulnerability Scanning', 'description' => 'Integrate a vulnerability scanner (like Trivy or Clair) into your CI pipeline. Fail the build if any high-severity vulnerabilities are found in your dependencies or Docker image.', 'category' => 'Security', 'required_skills' => ['Linux'], 'expected_outcome' => 'The CI build fails and reports "CVE-2023-XXXX found in library Y" if a vulnerable package is used.'],
                    ['title' => 'Performance Profiling', 'description' => 'Use Go\'s pprof tool to profile your application under load. Identify memory leaks or CPU hotspots and optimize the code accordingly.', 'category' => 'Backend', 'required_skills' => ['Go'], 'expected_outcome' => 'A flame graph is generated showing CPU usage. The report identifies the most expensive function calls.'],
                ]
            ],
            // 6. Social Media Sentiment Analysis (Data Science stack)
            [
                'title' => 'Social Media Sentiment Analysis',
                'description' => 'Analyze social media posts to determine public sentiment. Use NLP techniques and visualize the results.',
                'difficulty_level' => 'intermediate',
                'skills' => ['Python', 'Pandas', 'Scikit-learn', 'Django', 'PyTorch', 'Machine Learning', 'GraphQL'],
                'tasks' => [
                    ['title' => 'Data Collection', 'description' => 'Write a Python script to ingest data. You can use the Twitter API (if available) or a public dataset (like the Sentiment140 dataset) from Kaggle. Load the data into a Pandas DataFrame.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'Pandas'], 'expected_outcome' => 'The script outputs the first 5 rows of the DataFrame (`df.head()`), showing columns for "text", "timestamp", and "user". The data contains at least 1000 rows.'],
                    ['title' => 'Sentiment Model', 'description' => 'Train a machine learning model (e.g., Logistic Regression or Naive Bayes) to classify text as positive or negative. Use Scikit-learn for vectorization (TF-IDF) and training.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'Scikit-learn', 'Machine Learning'], 'expected_outcome' => 'The script saves a `model.pkl` file. Running the evaluation function prints an accuracy score > 70% on the test set.'],
                    ['title' => 'Advanced NLP', 'description' => 'Improve your model using Deep Learning. Implement an LSTM (Long Short-Term Memory) network using PyTorch to capture context and nuance in the text better than the simple classifier.', 'category' => 'AI/Data', 'required_skills' => ['PyTorch'], 'expected_outcome' => 'The training loop prints the loss decreasing over epochs. The final model achieves a higher F1-score than the baseline Logistic Regression model.'],
                    ['title' => 'Dashboard View', 'description' => 'Create a web dashboard using Django. Use Graphene-Django to expose a GraphQL API that allows the frontend to query sentiment data flexibly.', 'category' => 'Backend', 'required_skills' => ['Django', 'GraphQL'], 'expected_outcome' => 'Visiting `http://localhost:8000/graphql` allows executing a query `{ sentiments { text, score } }` which returns JSON data.'],
                    ['title' => 'Data Cleaning Pipeline', 'description' => 'Build a robust preprocessing pipeline. Remove stop words, URLs, and special characters. Perform lemmatization or stemming to normalize the text before feeding it to the model.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'Pandas'], 'expected_outcome' => 'Input: "Check out this link! http://test.com #wow". Output: "check link wow". All text is lowercase and free of special characters.'],
                    ['title' => 'Exploratory Data Analysis', 'description' => 'Perform EDA to understand your dataset. Create visualizations (histograms of tweet lengths, word clouds of most frequent words) using Matplotlib or Seaborn in a Jupyter Notebook.', 'category' => 'AI/Data', 'required_skills' => ['Python'], 'expected_outcome' => 'The notebook displays a histogram of tweet lengths and a word cloud image. The cells execute without errors.'],
                    ['title' => 'Topic Modeling', 'description' => 'Use Latent Dirichlet Allocation (LDA) to identify common topics within the dataset. Group tweets by these topics to see what people are talking about.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'Machine Learning'], 'expected_outcome' => 'The script prints 5 topics, each with 10 associated keywords (e.g., Topic 1: "game, play, win, team").'],
                    ['title' => 'Real-time Twitter Stream', 'description' => 'Connect to a live data stream (e.g., Twitter Streaming API). Process incoming tweets in real-time, predict their sentiment, and update the database.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'The database row count increases in real-time as the script runs. The console logs "Processed tweet: [Positive]".'],
                    ['title' => 'API for Sentiment Analysis', 'description' => 'Expose your trained model via a REST API using Django REST Framework. Allow external applications to send text and receive a sentiment score.', 'category' => 'Backend', 'required_skills' => ['Django'], 'expected_outcome' => 'POST /api/analyze with body `{"text": "I love this!"}` returns `{"sentiment": "positive", "score": 0.9}`.'],
                    ['title' => 'User Authentication', 'description' => 'Secure the dashboard so only authorized analysts can view the reports. Implement Django\'s built-in authentication system with login and logout pages.', 'category' => 'Backend', 'required_skills' => ['Django'], 'expected_outcome' => 'Accessing `/dashboard` redirects to `/login`. Logging in with valid credentials grants access.'],
                    ['title' => 'Export Reports', 'description' => 'Add functionality to generate PDF reports of the sentiment analysis. Include charts and summary statistics in the generated document.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'Clicking "Export PDF" downloads a file named `report.pdf` containing the generated charts and tables.'],
                    ['title' => 'Model Deployment', 'description' => 'Package your Django application and the trained model into a Docker container. Ensure the container can be run on any machine with Docker installed.', 'category' => 'DevOps', 'required_skills' => ['Docker'], 'expected_outcome' => '`docker build -t sentiment-app .` completes successfully. The container runs and serves the app.'],
                ]
            ],
            // 7. Cloud-Native File Storage (AWS/Node stack)
            [
                'title' => 'Cloud-Native File Storage',
                'description' => 'Build a Dropbox clone using cloud services. Handle file uploads, storage, and sharing securely.',
                'difficulty_level' => 'advanced',
                'skills' => ['AWS', 'Node.js', 'React', 'MongoDB', 'Microservices'],
                'tasks' => [
                    ['title' => 'Frontend Manager', 'description' => 'Create a React application that mimics a file explorer. Users should be able to navigate folders, view file lists, and see file details (size, type, date modified).', 'category' => 'Frontend', 'required_skills' => ['React', 'JavaScript'], 'expected_outcome' => 'The UI displays a list of files and folders. Clicking a folder navigates into it. The file list shows icons based on file type (e.g., PDF icon for .pdf).'],
                    ['title' => 'S3 Integration', 'description' => 'Implement secure file uploads to AWS S3. Create a backend endpoint that generates a pre-signed URL, allowing the frontend to upload files directly to S3 without passing through your server.', 'category' => 'DevOps', 'required_skills' => ['AWS', 'Node.js'], 'expected_outcome' => 'The backend returns a signed S3 URL. The frontend successfully PUTs the file to that URL, and the file appears in the S3 bucket console.'],
                    ['title' => 'File Metadata Service', 'description' => 'Build a microservice to store file metadata (name, S3 key, owner, parent folder) in MongoDB. This service will be the source of truth for the file structure.', 'category' => 'Backend', 'required_skills' => ['MongoDB', 'Microservices'], 'expected_outcome' => 'Uploading a file creates a document in the MongoDB `files` collection with `name`, `size`, `s3_key`, and `mime_type` fields.'],
                    ['title' => 'User Authentication', 'description' => 'Implement authentication to ensure users can only access their own files. Use JWTs and middleware to protect your API endpoints.', 'category' => 'Security', 'required_skills' => ['Node.js'], 'expected_outcome' => 'Accessing `/api/files` without a token returns 401. With a token, it returns only the files belonging to the authenticated user.'],
                    ['title' => 'Folder Structure Support', 'description' => 'Implement logic to handle nested folders. Update your database schema to support a tree structure (e.g., using parent_id references) and create API endpoints to create and delete folders.', 'category' => 'Backend', 'required_skills' => ['MongoDB'], 'expected_outcome' => 'The API returns a nested JSON structure or a flat list with `parent_id`. The frontend correctly renders the breadcrumb navigation (e.g., Home > Documents > Work).'],
                    ['title' => 'File Sharing', 'description' => 'Allow users to share files with others. Generate a unique, time-limited public link that allows anyone with the link to download the file.', 'category' => 'Backend', 'required_skills' => ['Node.js'], 'expected_outcome' => 'Clicking "Share" generates a link like `/share/xyz123`. Opening this link in an incognito window downloads the file. The link expires after 1 hour.'],
                    ['title' => 'Image Thumbnail Generation', 'description' => 'Use AWS Lambda to automatically generate thumbnails for uploaded images. Trigger the Lambda function on S3 object creation events.', 'category' => 'DevOps', 'required_skills' => ['AWS'], 'expected_outcome' => 'Uploading `image.jpg` to S3 triggers the Lambda, which creates `image_thumb.jpg` in a separate bucket or folder.'],
                    ['title' => 'File Versioning', 'description' => 'Enable S3 versioning and update your application to handle multiple versions of the same file. Allow users to restore previous versions.', 'category' => 'Backend', 'required_skills' => ['AWS'], 'expected_outcome' => 'Uploading a file with the same name creates a new version. The UI shows a "History" tab listing previous versions with "Restore" buttons.'],
                    ['title' => 'Drag and Drop Uploads', 'description' => 'Enhance the frontend to support drag-and-drop uploads. Show a progress bar for each file being uploaded.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'Dragging a file onto the browser window highlights the drop zone. Releasing it starts the upload with a visible progress percentage.'],
                    ['title' => 'Storage Quota Management', 'description' => 'Track storage usage per user. Prevent uploads if the user has exceeded their allocated storage quota.', 'category' => 'Backend', 'required_skills' => ['MongoDB'], 'expected_outcome' => 'If a user has 99MB used of 100MB quota, uploading a 2MB file fails with a "Quota Exceeded" error.'],
                    ['title' => 'Trash Bin', 'description' => 'Implement a "soft delete" feature. When a file is deleted, move it to a "Trash" folder instead of permanently deleting it. Allow users to restore files from the trash.', 'category' => 'Backend', 'required_skills' => ['MongoDB'], 'expected_outcome' => 'Deleted files disappear from the main view but appear in the "Trash" view. They can be restored or permanently deleted.'],
                    ['title' => 'Search Files', 'description' => 'Implement a search bar that allows users to find files by name. Index the file metadata in MongoDB or Elasticsearch for fast retrieval.', 'category' => 'Backend', 'required_skills' => ['MongoDB'], 'expected_outcome' => 'Typing "invoice" in the search bar instantly filters the file list to show only files containing "invoice" in the name.'],
                    ['title' => 'File Preview', 'description' => 'Add a preview feature for common file types (PDF, Images, Text). Use a library like react-pdf or simply an iframe for supported types.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'Clicking a PDF file opens a modal displaying the PDF content without downloading it.'],
                    ['title' => 'Multipart Uploads', 'description' => 'Support uploading large files (e.g., >100MB) using S3 Multipart Uploads. This improves reliability and allows for pausing/resuming uploads.', 'category' => 'Backend', 'required_skills' => ['AWS'], 'expected_outcome' => 'Uploading a 500MB file works reliably. The network tab shows multiple concurrent PUT requests for different parts of the file.'],
                    ['title' => 'CDN Integration', 'description' => 'Configure AWS CloudFront to serve your files. This reduces latency for users around the world.', 'category' => 'DevOps', 'required_skills' => ['AWS'], 'expected_outcome' => 'File download URLs point to the CloudFront domain (e.g., `d123.cloudfront.net`) instead of the raw S3 bucket URL.'],
                    ['title' => 'Data Encryption', 'description' => 'Ensure all files are encrypted at rest in S3 using Server-Side Encryption (SSE-S3 or SSE-KMS).', 'category' => 'Security', 'required_skills' => ['AWS'], 'expected_outcome' => 'Inspecting the S3 object properties in the AWS Console shows "Server-side encryption: Enabled".'],
                    ['title' => 'Access Control Lists', 'description' => 'Implement granular permissions (Read, Write, Admin) for shared folders. Allow users to invite others with specific access levels.', 'category' => 'Security', 'required_skills' => ['MongoDB'], 'expected_outcome' => 'User A shares a folder with User B (Read Only). User B can view files but cannot upload or delete them.'],
                    ['title' => 'Activity Log', 'description' => 'Log all file access and modification events. Show users a history of who accessed their files and when.', 'category' => 'Backend', 'required_skills' => ['MongoDB'], 'expected_outcome' => 'The "Activity" tab shows a list: "User A uploaded file.txt", "User B downloaded file.txt".'],
                ]
            ],
            // 8. Interactive 3D Configurator (Frontend Creative stack)
            [
                'title' => 'Interactive 3D Product Configurator',
                'description' => 'Create a web-based 3D car configurator. Users can change colors, wheels, and view the model from all angles.',
                'difficulty_level' => 'intermediate',
                'skills' => ['JavaScript', 'React', 'CSS', 'Webpack', 'Sass/SCSS'],
                'tasks' => [
                    ['title' => 'Configurator UI', 'description' => 'Controls for customization.', 'category' => 'Frontend', 'required_skills' => ['React', 'CSS'], 'expected_outcome' => 'Floating UI panel styled with CSS.'],
                    ['title' => '3D Scene Setup', 'description' => 'Initialize the 3D environment.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Canvas rendering a 3D model using Three.js (via JS).'],
                    ['title' => 'Asset Optimization', 'description' => 'Optimize 3D assets for web.', 'category' => 'Frontend', 'required_skills' => ['Webpack'], 'expected_outcome' => 'Webpack config handling model file loading and compression.'],
                    ['title' => 'Camera Controls', 'description' => 'Allow user to rotate view.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'OrbitControls implementation.'],
                    ['title' => 'Material Switching', 'description' => 'Change car colors.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Clicking color updates 3D model texture.'],
                    ['title' => 'Animation Triggers', 'description' => 'Open doors/trunk.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Smooth animations on click.'],
                    ['title' => 'Environment Lighting', 'description' => 'Realistic reflections.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'HDRi map loaded.'],
                    ['title' => 'Screenshot Feature', 'description' => 'Capture current view.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Download canvas as PNG.'],
                    ['title' => 'Price Calculation', 'description' => 'Update price based on options.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'Dynamic price display.'],
                    ['title' => 'Save Configuration', 'description' => 'Persist user choice.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Save to LocalStorage.'],
                    ['title' => 'Loading States', 'description' => 'Handle large asset loading.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'Progress bar during model load.'],
                    ['title' => 'Mobile Touch Support', 'description' => 'Optimize for touch.', 'category' => 'Frontend', 'required_skills' => ['CSS'], 'expected_outcome' => 'Touch gestures work for rotation.'],
                ]
            ],
            // 9. Automated CI/CD Pipeline (DevOps stack)
            [
                'title' => 'Automated CI/CD Pipeline Generator',
                'description' => 'Build a system that automatically sets up CI/CD pipelines for new projects. Focus on automation and infrastructure as code.',
                'difficulty_level' => 'advanced',
                'skills' => ['Jenkins', 'Kubernetes', 'Go', 'GitHub Actions', 'Terraform'],
                'tasks' => [
                    ['title' => 'Pipeline Definition', 'description' => 'Define standard pipeline steps.', 'category' => 'DevOps', 'required_skills' => ['Jenkins', 'GitHub Actions'], 'expected_outcome' => 'Jenkinsfile or Workflow YAML template.'],
                    ['title' => 'Infrastructure as Code', 'description' => 'Provision cluster resources.', 'category' => 'DevOps', 'required_skills' => ['Terraform', 'Kubernetes'], 'expected_outcome' => 'Terraform scripts to provision K8s namespace.'],
                    ['title' => 'CLI Tool', 'description' => 'Tool to scaffold the pipeline.', 'category' => 'Backend', 'required_skills' => ['Go'], 'expected_outcome' => 'Go binary that generates config files based on user input.'],
                    ['title' => 'Git Webhook Handler', 'description' => 'Trigger builds on push.', 'category' => 'Backend', 'required_skills' => ['Go'], 'expected_outcome' => 'Webhook listener service.'],
                    ['title' => 'Build Artifact Storage', 'description' => 'Store binaries.', 'category' => 'DevOps', 'required_skills' => ['Jenkins'], 'expected_outcome' => 'Artifact archiving configuration.'],
                    ['title' => 'Unit Test Integration', 'description' => 'Run tests in pipeline.', 'category' => 'DevOps', 'required_skills' => ['GitHub Actions'], 'expected_outcome' => 'Test report generation.'],
                    ['title' => 'Code Quality Gate', 'description' => 'Block bad code.', 'category' => 'DevOps', 'required_skills' => ['Jenkins'], 'expected_outcome' => 'SonarQube integration.'],
                    ['title' => 'Security Scanning', 'description' => 'Check for vulnerabilities.', 'category' => 'DevOps', 'required_skills' => ['GitHub Actions'], 'expected_outcome' => 'SAST tool integration.'],
                    ['title' => 'Container Registry', 'description' => 'Push Docker images.', 'category' => 'DevOps', 'required_skills' => ['Docker'], 'expected_outcome' => 'Automated image push.'],
                    ['title' => 'Deployment Strategies', 'description' => 'Zero downtime deploy.', 'category' => 'DevOps', 'required_skills' => ['Kubernetes'], 'expected_outcome' => 'Blue/Green deployment setup.'],
                    ['title' => 'Rollback Mechanism', 'description' => 'Revert failed deploys.', 'category' => 'DevOps', 'required_skills' => ['Go'], 'expected_outcome' => 'Command to rollback release.'],
                    ['title' => 'Notification System', 'description' => 'Alert on failure.', 'category' => 'DevOps', 'required_skills' => ['Jenkins'], 'expected_outcome' => 'Slack notification integration.'],
                    ['title' => 'Pipeline Visualization', 'description' => 'UI for pipeline status.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'Dashboard showing build history.'],
                    ['title' => 'Multi-Environment', 'description' => 'Dev/Staging/Prod.', 'category' => 'DevOps', 'required_skills' => ['Terraform'], 'expected_outcome' => 'Separate state files per env.'],
                    ['title' => 'Secret Management', 'description' => 'Inject secrets safely.', 'category' => 'Security', 'required_skills' => ['Kubernetes'], 'expected_outcome' => 'K8s Secrets integration.'],
                    ['title' => 'Log Aggregation', 'description' => 'Centralize build logs.', 'category' => 'DevOps', 'required_skills' => ['Go'], 'expected_outcome' => 'Log shipping to ELK.'],
                    ['title' => 'Cost Estimation', 'description' => 'Predict infra cost.', 'category' => 'DevOps', 'required_skills' => ['Terraform'], 'expected_outcome' => 'Infracost integration.'],
                    ['title' => 'Self-Healing', 'description' => 'Restart failed pods.', 'category' => 'DevOps', 'required_skills' => ['Kubernetes'], 'expected_outcome' => 'Liveness/Readiness probes.'],
                ]
            ],
            // 10. Music Streaming Service (Mobile/Backend stack)
            [
                'title' => 'Music Streaming Service',
                'description' => 'Develop a mobile music player with backend streaming. Handle audio buffering, playlists, and user libraries.',
                'difficulty_level' => 'intermediate',
                'skills' => ['Swift', 'Kotlin', 'Node.js', 'MongoDB', 'Flutter', 'REST'],
                'tasks' => [
                    ['title' => 'Streaming API', 'description' => 'Backend to serve audio chunks.', 'category' => 'Backend', 'required_skills' => ['Node.js', 'REST'], 'expected_outcome' => 'Node.js REST endpoint supporting range requests.'],
                    ['title' => 'iOS Player', 'description' => 'Build the audio player for iOS.', 'category' => 'Mobile', 'required_skills' => ['Swift'], 'expected_outcome' => 'iOS app playing audio from URL.'],
                    ['title' => 'Android Player', 'description' => 'Build the audio player for Android.', 'category' => 'Mobile', 'required_skills' => ['Kotlin'], 'expected_outcome' => 'Android app playing audio from URL.'],
                    ['title' => 'Playlist Management', 'description' => 'Create and edit playlists.', 'category' => 'Backend', 'required_skills' => ['Node.js', 'MongoDB'], 'expected_outcome' => 'CRUD endpoints for playlists.'],
                    ['title' => 'User Library', 'description' => 'Save favorite songs.', 'category' => 'Backend', 'required_skills' => ['Node.js'], 'expected_outcome' => 'Like/Unlike functionality.'],
                    ['title' => 'Search Functionality', 'description' => 'Find songs by artist/title.', 'category' => 'Backend', 'required_skills' => ['MongoDB'], 'expected_outcome' => 'Text search query.'],
                    ['title' => 'Audio Caching', 'description' => 'Save data usage.', 'category' => 'Mobile', 'required_skills' => ['Swift', 'Kotlin'], 'expected_outcome' => 'Local file storage for played songs.'],
                    ['title' => 'Background Playback', 'description' => 'Play when app is closed.', 'category' => 'Mobile', 'required_skills' => ['Swift', 'Kotlin'], 'expected_outcome' => 'Audio service configuration.'],
                    ['title' => 'Lock Screen Controls', 'description' => 'Control media from lock screen.', 'category' => 'Mobile', 'required_skills' => ['Swift', 'Kotlin'], 'expected_outcome' => 'Media session integration.'],
                    ['title' => 'Artist Profiles', 'description' => 'Show artist info.', 'category' => 'Frontend', 'required_skills' => ['Flutter'], 'expected_outcome' => 'UI page with bio and top songs.'],
                    ['title' => 'Album Art Optimization', 'description' => 'Efficient image loading.', 'category' => 'Mobile', 'required_skills' => ['Flutter'], 'expected_outcome' => 'Cached network images.'],
                    ['title' => 'Lyrics Display', 'description' => 'Show synced lyrics.', 'category' => 'Frontend', 'required_skills' => ['Flutter'], 'expected_outcome' => 'Scrolling text view.'],
                ]
            ],
            // 11. Corporate Employee Directory (.NET stack)
            [
                'title' => 'Corporate Employee Directory',
                'description' => 'Build an internal directory for a large corporation. Focus on Active Directory integration and enterprise search.',
                'difficulty_level' => 'beginner',
                'skills' => ['.NET Core', 'C#', 'SQL', 'Azure', 'Bootstrap', 'REST'],
                'tasks' => [
                    ['title' => 'Database Design', 'description' => 'Schema for organizational structure.', 'category' => 'Database', 'required_skills' => ['SQL'], 'expected_outcome' => 'SQL migration script for Employees and Departments tables.'],
                    ['title' => 'Employee API', 'description' => 'CRUD API for employee records.', 'category' => 'Backend', 'required_skills' => ['.NET Core', 'C#', 'REST'], 'expected_outcome' => '.NET Core Web API project.'],
                    ['title' => 'Cloud Hosting', 'description' => 'Deploy to Azure App Service.', 'category' => 'DevOps', 'required_skills' => ['Azure'], 'expected_outcome' => 'Live URL on Azure.'],
                    ['title' => 'Search & Filter', 'description' => 'Find employees by department.', 'category' => 'Frontend', 'required_skills' => ['Bootstrap'], 'expected_outcome' => 'Filterable list view.'],
                    ['title' => 'Employee Detail View', 'description' => 'Show full profile.', 'category' => 'Frontend', 'required_skills' => ['HTML'], 'expected_outcome' => 'Modal or separate page with details.'],
                    ['title' => 'Admin Panel', 'description' => 'Add or edit employees.', 'category' => 'Frontend', 'required_skills' => ['.NET Core'], 'expected_outcome' => 'Form with validation.'],
                ]
            ],
            // 12. Personal Finance Tracker (Vue stack)
            [
                'title' => 'Personal Finance Tracker',
                'description' => 'A simple, responsive web app to track income and expenses. Great for learning Vue.js and reactive data binding.',
                'difficulty_level' => 'beginner',
                'skills' => ['Vue.js', 'Supabase', 'CSS', 'HTML'],
                'tasks' => [
                    ['title' => 'Dashboard View', 'description' => 'Display current balance and list.', 'category' => 'Frontend', 'required_skills' => ['Vue.js', 'HTML'], 'expected_outcome' => 'Vue component rendering transaction list.'],
                    ['title' => 'Styling', 'description' => 'Make it look modern.', 'category' => 'Frontend', 'required_skills' => ['CSS'], 'expected_outcome' => 'Responsive layout using Flexbox/Grid.'],
                    ['title' => 'Data Sync', 'description' => 'Save data to cloud.', 'category' => 'Backend', 'required_skills' => ['Supabase'], 'expected_outcome' => 'Real-time Supabase updates.'],
                    ['title' => 'Add Transaction Form', 'description' => 'Input income or expense.', 'category' => 'Frontend', 'required_skills' => ['Vue.js'], 'expected_outcome' => 'Form with amount and date fields.'],
                    ['title' => 'Category Management', 'description' => 'Tag transactions.', 'category' => 'Frontend', 'required_skills' => ['Vue.js'], 'expected_outcome' => 'Dropdown to select category.'],
                    ['title' => 'Monthly Summary Chart', 'description' => 'Visualize spending.', 'category' => 'Frontend', 'required_skills' => ['Vue.js'], 'expected_outcome' => 'Pie chart of expenses.'],
                ]
            ],
            // 13. Travel Booking System (Java stack)
            [
                'title' => 'Travel Booking System',
                'description' => 'Enterprise-grade booking system for flights and hotels. Focus on strict typing, design patterns, and relational data.',
                'difficulty_level' => 'intermediate',
                'skills' => ['Java', 'Spring Boot', 'PostgreSQL', 'Angular', 'Oracle', 'REST'],
                'tasks' => [
                    ['title' => 'Data Persistence', 'description' => 'Store complex booking data.', 'category' => 'Database', 'required_skills' => ['PostgreSQL'], 'expected_outcome' => 'PostgreSQL schema with foreign keys.'],
                    ['title' => 'Booking Engine', 'description' => 'Core logic for reservations.', 'category' => 'Backend', 'required_skills' => ['Java', 'Spring Boot', 'REST'], 'expected_outcome' => 'Spring Boot REST controller.'],
                    ['title' => 'Legacy Data Sync', 'description' => 'Sync with legacy Oracle DB.', 'category' => 'Database', 'required_skills' => ['Oracle'], 'expected_outcome' => 'Java job to sync data.'],
                    ['title' => 'Admin Panel', 'description' => 'Manage flights and hotels.', 'category' => 'Frontend', 'required_skills' => ['Angular'], 'expected_outcome' => 'Angular dashboard for admins.'],
                    ['title' => 'Flight Search API', 'description' => 'Filter flights by date/dest.', 'category' => 'Backend', 'required_skills' => ['Java', 'Spring Boot'], 'expected_outcome' => 'Search endpoint with query params.'],
                    ['title' => 'Hotel Availability', 'description' => 'Check room status.', 'category' => 'Backend', 'required_skills' => ['Java', 'SQL'], 'expected_outcome' => 'Logic to prevent double booking.'],
                    ['title' => 'Payment Processing', 'description' => 'Handle payments.', 'category' => 'Backend', 'required_skills' => ['Java'], 'expected_outcome' => 'Mock payment service integration.'],
                    ['title' => 'Email Confirmation', 'description' => 'Send booking details.', 'category' => 'Backend', 'required_skills' => ['Java'], 'expected_outcome' => 'SMTP integration.'],
                    ['title' => 'User Profile', 'description' => 'View booking history.', 'category' => 'Frontend', 'required_skills' => ['Angular'], 'expected_outcome' => 'User dashboard page.'],
                    ['title' => 'Cancellation Logic', 'description' => 'Handle refunds.', 'category' => 'Backend', 'required_skills' => ['Java'], 'expected_outcome' => 'Business logic for cancellations.'],
                    ['title' => 'Seat Selection', 'description' => 'Visual seat map.', 'category' => 'Frontend', 'required_skills' => ['Angular'], 'expected_outcome' => 'Interactive SVG map.'],
                    ['title' => 'Multi-language Support', 'description' => 'i18n implementation.', 'category' => 'Frontend', 'required_skills' => ['Angular'], 'expected_outcome' => 'Language switcher.'],
                ]
            ],
            // 14. Log Analysis Tool (Elastic stack)
            [
                'title' => 'Log Analysis & Monitoring Tool',
                'description' => 'Ingest and visualize server logs. Detect anomalies and alert admins.',
                'difficulty_level' => 'advanced',
                'skills' => ['Elasticsearch', 'Python', 'Linux', 'Nginx', 'Google Cloud'],
                'tasks' => [
                    ['title' => 'Log Ingestion', 'description' => 'Script to parse logs.', 'category' => 'Backend', 'required_skills' => ['Python', 'Linux'], 'expected_outcome' => 'Python script reading /var/log/nginx/access.log.'],
                    ['title' => 'Cloud Storage', 'description' => 'Archive logs to cloud.', 'category' => 'DevOps', 'required_skills' => ['Google Cloud'], 'expected_outcome' => 'Script uploading to Google Cloud Storage.'],
                    ['title' => 'Indexing', 'description' => 'Store logs for searching.', 'category' => 'Database', 'required_skills' => ['Elasticsearch'], 'expected_outcome' => 'Elasticsearch index mapping.'],
                    ['title' => 'Server Config', 'description' => 'Configure web server logging.', 'category' => 'DevOps', 'required_skills' => ['Nginx'], 'expected_outcome' => 'Custom Nginx log format configuration.'],
                    ['title' => 'Real-time Alerting', 'description' => 'Notify on errors.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'Slack alert on 500 errors.'],
                    ['title' => 'Dashboard Visualization', 'description' => 'Graph log volume.', 'category' => 'Frontend', 'required_skills' => ['Elasticsearch'], 'expected_outcome' => 'Kibana dashboard setup.'],
                    ['title' => 'Log Rotation', 'description' => 'Manage disk space.', 'category' => 'DevOps', 'required_skills' => ['Linux'], 'expected_outcome' => 'logrotate configuration.'],
                    ['title' => 'Anomaly Detection', 'description' => 'Find unusual patterns.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'Machine Learning'], 'expected_outcome' => 'Script flagging outliers.'],
                    ['title' => 'User Access Control', 'description' => 'Secure the dashboard.', 'category' => 'Security', 'required_skills' => ['Nginx'], 'expected_outcome' => 'Basic Auth setup.'],
                    ['title' => 'Log Query API', 'description' => 'Search logs programmatically.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'Flask endpoint querying ES.'],
                    ['title' => 'Agent Deployment', 'description' => 'Deploy collector to nodes.', 'category' => 'DevOps', 'required_skills' => ['Linux'], 'expected_outcome' => 'Ansible playbook.'],
                    ['title' => 'High Availability', 'description' => 'Cluster setup.', 'category' => 'DevOps', 'required_skills' => ['Elasticsearch'], 'expected_outcome' => '3-node ES cluster config.'],
                    ['title' => 'Data Retention', 'description' => 'Delete old logs.', 'category' => 'Database', 'required_skills' => ['Elasticsearch'], 'expected_outcome' => 'Curator job setup.'],
                    ['title' => 'Custom Formats', 'description' => 'Parse app logs.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'Regex parser for custom log format.'],
                    ['title' => 'Geo-IP Tagging', 'description' => 'Locate users.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'Enrich logs with country code.'],
                    ['title' => 'Performance Optimization', 'description' => 'Tune ingestion rate.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'Bulk indexing implementation.'],
                    ['title' => 'Backup & Restore', 'description' => 'Disaster recovery.', 'category' => 'DevOps', 'required_skills' => ['Elasticsearch'], 'expected_outcome' => 'Snapshot repository config.'],
                    ['title' => 'Compliance Reporting', 'description' => 'Generate audit reports.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'Script generating compliance PDF.'],
                ]
            ],
            // 15. Smart Home IoT Dashboard (IoT stack)
            [
                'title' => 'Smart Home IoT Dashboard',
                'description' => 'Control smart devices from a central dashboard. Simulate IoT devices using Python scripts.',
                'difficulty_level' => 'intermediate',
                'skills' => ['Python', 'Linux', 'React', 'Node.js', 'MQTT'],
                'tasks' => [
                    ['title' => 'Device Simulator', 'description' => 'Simulate a smart bulb.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'Python script sending MQTT messages.'],
                    ['title' => 'Hub Server', 'description' => 'Receive device status.', 'category' => 'Backend', 'required_skills' => ['Node.js', 'Linux'], 'expected_outcome' => 'Node.js server running on Linux.'],
                    ['title' => 'Control Panel', 'description' => 'Toggle devices on/off.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'React UI with switches reflecting device state.'],
                    ['title' => 'Automation Rules', 'description' => 'Trigger actions on events.', 'category' => 'Backend', 'required_skills' => ['Node.js'], 'expected_outcome' => 'Logic engine (e.g., turn on light if motion detected).'],
                    ['title' => 'Energy Monitoring', 'description' => 'Track power usage.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'Chart showing kWh consumption.'],
                    ['title' => 'Voice Control', 'description' => 'Mock voice commands.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'Script parsing text commands.'],
                    ['title' => 'Mobile Interface', 'description' => 'Responsive design.', 'category' => 'Frontend', 'required_skills' => ['CSS'], 'expected_outcome' => 'Mobile-friendly layout.'],
                    ['title' => 'Device Discovery', 'description' => 'Auto-detect new devices.', 'category' => 'Backend', 'required_skills' => ['Node.js'], 'expected_outcome' => 'mDNS discovery implementation.'],
                    ['title' => 'Firmware Update', 'description' => 'Simulate OTA updates.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'Process to update simulator version.'],
                    ['title' => 'Security Alarm', 'description' => 'Arm/Disarm system.', 'category' => 'Backend', 'required_skills' => ['Node.js'], 'expected_outcome' => 'State machine for alarm system.'],
                    ['title' => 'Temperature History', 'description' => 'Log sensor data.', 'category' => 'Database', 'required_skills' => ['Node.js'], 'expected_outcome' => 'Time-series data storage.'],
                    ['title' => 'Multi-User Access', 'description' => 'Permissions for family.', 'category' => 'Security', 'required_skills' => ['Node.js'], 'expected_outcome' => 'Role-based access control.'],
                ]
            ],
            // 16. Ruby on Rails Blog (Ruby stack)
            [
                'title' => 'Classic Blog Platform',
                'description' => 'Build a standard blog using the Rails framework. Focus on MVC architecture and convention over configuration.',
                'difficulty_level' => 'beginner',
                'skills' => ['Ruby', 'Ruby on Rails', 'SQLite', 'HTML'],
                'tasks' => [
                    ['title' => 'Scaffold Resources', 'description' => 'Generate Posts and Comments.', 'category' => 'Backend', 'required_skills' => ['Ruby on Rails', 'Ruby'], 'expected_outcome' => 'Rails scaffold command output.'],
                    ['title' => 'Database Migration', 'description' => 'Set up the local DB.', 'category' => 'Database', 'required_skills' => ['SQLite'], 'expected_outcome' => 'db/migrate files.'],
                    ['title' => 'View Templates', 'description' => 'Design the post layout.', 'category' => 'Frontend', 'required_skills' => ['HTML'], 'expected_outcome' => 'ERB templates for show and index actions.'],
                    ['title' => 'User Registration', 'description' => 'Add authentication.', 'category' => 'Backend', 'required_skills' => ['Ruby on Rails'], 'expected_outcome' => 'Devise gem integration.'],
                    ['title' => 'Commenting System', 'description' => 'Allow users to comment.', 'category' => 'Backend', 'required_skills' => ['Ruby on Rails'], 'expected_outcome' => 'Nested resources for comments.'],
                    ['title' => 'Tagging Posts', 'description' => 'Categorize content.', 'category' => 'Backend', 'required_skills' => ['Ruby on Rails'], 'expected_outcome' => 'Many-to-many relationship for tags.'],
                ]
            ],
            // 17. Rust System Utility (Systems stack)
            [
                'title' => 'High-Performance System Monitor',
                'description' => 'Build a CLI tool to monitor system resources with minimal overhead. Learn memory safety and systems programming.',
                'difficulty_level' => 'advanced',
                'skills' => ['Rust', 'Linux', 'Git'],
                'tasks' => [
                    ['title' => 'Version Control', 'description' => 'Manage source code.', 'category' => 'DevOps', 'required_skills' => ['Git'], 'expected_outcome' => 'Clean git commit history.'],
                    ['title' => 'Resource Reading', 'description' => 'Read CPU/RAM usage.', 'category' => 'Backend', 'required_skills' => ['Rust', 'Linux'], 'expected_outcome' => 'Rust function parsing /proc filesystem.'],
                    ['title' => 'CLI Argument Parsing', 'description' => 'Handle flags.', 'category' => 'Backend', 'required_skills' => ['Rust'], 'expected_outcome' => 'Clap crate integration.'],
                    ['title' => 'Process Listing', 'description' => 'Show running procs.', 'category' => 'Backend', 'required_skills' => ['Rust', 'Linux'], 'expected_outcome' => 'List of PIDs and names.'],
                    ['title' => 'Kill Process', 'description' => 'Terminate tasks.', 'category' => 'Backend', 'required_skills' => ['Rust'], 'expected_outcome' => 'Command to kill PID.'],
                    ['title' => 'Network Monitor', 'description' => 'Track bandwidth.', 'category' => 'Backend', 'required_skills' => ['Rust', 'Linux'], 'expected_outcome' => 'Real-time upload/download rates.'],
                    ['title' => 'Disk I/O Monitor', 'description' => 'Track disk usage.', 'category' => 'Backend', 'required_skills' => ['Rust'], 'expected_outcome' => 'Read/Write speeds.'],
                    ['title' => 'Configuration File', 'description' => 'Load settings.', 'category' => 'Backend', 'required_skills' => ['Rust'], 'expected_outcome' => 'TOML config parser.'],
                    ['title' => 'Interactive Mode', 'description' => 'TUI interface.', 'category' => 'Frontend', 'required_skills' => ['Rust'], 'expected_outcome' => 'Ratatui dashboard.'],
                    ['title' => 'Logging to File', 'description' => 'Save metrics.', 'category' => 'Backend', 'required_skills' => ['Rust'], 'expected_outcome' => 'Log rotation implementation.'],
                    ['title' => 'Daemon Mode', 'description' => 'Run in background.', 'category' => 'Backend', 'required_skills' => ['Rust', 'Linux'], 'expected_outcome' => 'Systemd service file.'],
                    ['title' => 'Alerting Thresholds', 'description' => 'Warn on high load.', 'category' => 'Backend', 'required_skills' => ['Rust'], 'expected_outcome' => 'Logic to trigger alerts.'],
                    ['title' => 'JSON Output', 'description' => 'Machine readable.', 'category' => 'Backend', 'required_skills' => ['Rust'], 'expected_outcome' => '--json flag support.'],
                    ['title' => 'Plugin System', 'description' => 'Extend functionality.', 'category' => 'Backend', 'required_skills' => ['Rust'], 'expected_outcome' => 'Dynamic library loading.'],
                    ['title' => 'Cross-Compilation', 'description' => 'Build for others.', 'category' => 'DevOps', 'required_skills' => ['Rust'], 'expected_outcome' => 'Binaries for Windows and Linux.'],
                    ['title' => 'Unit Testing', 'description' => 'Ensure stability.', 'category' => 'DevOps', 'required_skills' => ['Rust'], 'expected_outcome' => 'Cargo test suite.'],
                    ['title' => 'Benchmark Suite', 'description' => 'Measure speed.', 'category' => 'DevOps', 'required_skills' => ['Rust'], 'expected_outcome' => 'Criterion benchmarks.'],
                    ['title' => 'Documentation', 'description' => 'Explain usage.', 'category' => 'DevOps', 'required_skills' => ['Rust'], 'expected_outcome' => 'Rustdoc generated site.'],
                ]
            ],
            // 18. Next.js E-commerce Storefront (Modern Frontend stack)
            [
                'title' => 'Next.js E-commerce Storefront',
                'description' => 'A blazing fast storefront using Server Side Rendering. Focus on SEO and performance.',
                'difficulty_level' => 'intermediate',
                'skills' => ['Next.js', 'React', 'Tailwind CSS', 'TypeScript'],
                'tasks' => [
                    ['title' => 'Page Routing', 'description' => 'Set up product pages.', 'category' => 'Frontend', 'required_skills' => ['Next.js', 'React'], 'expected_outcome' => 'Next.js dynamic routes for products.'],
                    ['title' => 'Styling System', 'description' => 'Implement a design system.', 'category' => 'Frontend', 'required_skills' => ['Tailwind CSS'], 'expected_outcome' => 'Tailwind config and utility class usage.'],
                    ['title' => 'Type Safety', 'description' => 'Ensure code quality.', 'category' => 'Frontend', 'required_skills' => ['TypeScript'], 'expected_outcome' => 'Strict TypeScript interfaces for Product data.'],
                    ['title' => 'Product Search', 'description' => 'Filter products.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'Instant search bar.'],
                    ['title' => 'Shopping Cart', 'description' => 'Manage items.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'Context API for cart state.'],
                    ['title' => 'Checkout Form', 'description' => 'Collect shipping info.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'Multi-step form.'],
                    ['title' => 'SEO Optimization', 'description' => 'Rank higher.', 'category' => 'Frontend', 'required_skills' => ['Next.js'], 'expected_outcome' => 'Dynamic meta tags.'],
                    ['title' => 'Image Optimization', 'description' => 'Fast loading.', 'category' => 'Frontend', 'required_skills' => ['Next.js'], 'expected_outcome' => 'Next/Image component usage.'],
                    ['title' => 'API Integration', 'description' => 'Fetch data.', 'category' => 'Frontend', 'required_skills' => ['Next.js'], 'expected_outcome' => 'getStaticProps/getServerSideProps.'],
                    ['title' => 'Dark Mode', 'description' => 'Theme toggle.', 'category' => 'Frontend', 'required_skills' => ['Tailwind CSS'], 'expected_outcome' => 'System preference detection.'],
                    ['title' => 'Newsletter Signup', 'description' => 'Capture emails.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'Form submission handler.'],
                    ['title' => 'Performance Audit', 'description' => 'Speed check.', 'category' => 'DevOps', 'required_skills' => ['Next.js'], 'expected_outcome' => 'Lighthouse score > 90.'],
                ]
            ],
            // 19. Svelte Weather App (Svelte stack)
            [
                'title' => 'Svelte Weather App',
                'description' => 'A lightweight weather application. Experience the compiler-based approach of Svelte.',
                'difficulty_level' => 'beginner',
                'skills' => ['Svelte', 'JavaScript', 'CSS', 'HTML', 'Vite'],
                'tasks' => [
                    ['title' => 'Build Setup', 'description' => 'Configure build tool.', 'category' => 'Frontend', 'required_skills' => ['Vite'], 'expected_outcome' => 'Vite config file.'],
                    ['title' => 'Component Structure', 'description' => 'Create weather card component.', 'category' => 'Frontend', 'required_skills' => ['Svelte', 'HTML'], 'expected_outcome' => '.svelte file with script, style, and template.'],
                    ['title' => 'State Management', 'description' => 'Handle weather data.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Svelte store or reactive variables.'],
                    ['title' => 'API Integration', 'description' => 'Fetch live data.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Fetch call to OpenWeatherMap.'],
                    ['title' => 'Search City', 'description' => 'User input.', 'category' => 'Frontend', 'required_skills' => ['Svelte'], 'expected_outcome' => 'Input binding to update query.'],
                    ['title' => 'Error Handling', 'description' => 'Show invalid city message.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Conditional rendering of error alert.'],
                ]
            ],
            // 20. Python Data Analysis Script (Data stack)
            [
                'title' => 'Sales Data Analysis Report',
                'description' => 'Automate the generation of sales reports from raw CSV data.',
                'difficulty_level' => 'beginner',
                'skills' => ['Python', 'Pandas', 'NumPy'],
                'tasks' => [
                    ['title' => 'Data Cleaning', 'description' => 'Remove duplicates and nulls.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'Pandas'], 'expected_outcome' => 'Python script outputting clean CSV.'],
                    ['title' => 'Statistical Analysis', 'description' => 'Calculate averages and trends.', 'category' => 'AI/Data', 'required_skills' => ['NumPy'], 'expected_outcome' => 'Calculated metrics printed to console.'],
                    ['title' => 'Data Visualization', 'description' => 'Plot graphs.', 'category' => 'AI/Data', 'required_skills' => ['Python'], 'expected_outcome' => 'Matplotlib charts saved as PNG.'],
                    ['title' => 'Export to Excel', 'description' => 'Save report.', 'category' => 'AI/Data', 'required_skills' => ['Pandas'], 'expected_outcome' => '.xlsx file with multiple sheets.'],
                    ['title' => 'Command Line Args', 'description' => 'Dynamic input file.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'argparse integration.'],
                    ['title' => 'Logging', 'description' => 'Track execution.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'Log file with timestamps.'],
                ]
            ],
            // 21. Personal Portfolio Website (Absolute Beginner)
            [
                'title' => 'Personal Portfolio Website',
                'description' => 'Build a simple static website to showcase your skills. Focus on semantic HTML and basic CSS styling.',
                'difficulty_level' => 'beginner',
                'skills' => ['HTML', 'CSS'],
                'tasks' => [
                    ['title' => 'HTML Structure', 'description' => 'Create the basic HTML5 structure with header, main, and footer.', 'category' => 'Frontend', 'required_skills' => ['HTML'], 'expected_outcome' => 'index.html file with semantic tags.'],
                    ['title' => 'Styling with CSS', 'description' => 'Style the page using external CSS.', 'category' => 'Frontend', 'required_skills' => ['CSS'], 'expected_outcome' => 'style.css file linked and applied.'],
                    ['title' => 'Responsive Design', 'description' => 'Make the layout responsive for mobile devices.', 'category' => 'Frontend', 'required_skills' => ['CSS'], 'expected_outcome' => 'Media queries added for smaller screens.'],
                    ['title' => 'Project Gallery', 'description' => 'Showcase work.', 'category' => 'Frontend', 'required_skills' => ['HTML', 'CSS'], 'expected_outcome' => 'Grid layout of project cards.'],
                    ['title' => 'Contact Form', 'description' => 'Allow messages.', 'category' => 'Frontend', 'required_skills' => ['HTML'], 'expected_outcome' => 'Form with mailto action.'],
                    ['title' => 'Deploy to GitHub Pages', 'description' => 'Go live.', 'category' => 'DevOps', 'required_skills' => ['Git'], 'expected_outcome' => 'Live URL.'],
                ]
            ],
            // 22. Interactive Counter App (JavaScript Basics)
            [
                'title' => 'Interactive Counter App',
                'description' => 'Create a simple web page with a number and buttons to increment or decrement it. Learn DOM manipulation.',
                'difficulty_level' => 'beginner',
                'skills' => ['HTML', 'CSS', 'JavaScript'],
                'tasks' => [
                    ['title' => 'UI Layout', 'description' => 'Create the HTML for the counter display and buttons.', 'category' => 'Frontend', 'required_skills' => ['HTML', 'CSS'], 'expected_outcome' => 'Centered number with + and - buttons.'],
                    ['title' => 'JavaScript Logic', 'description' => 'Write the logic to update the count.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Clicking buttons updates the displayed number.'],
                    ['title' => 'Reset Button', 'description' => 'Set count to zero.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Button resets the counter.'],
                    ['title' => 'Custom Step Input', 'description' => 'Increment by X.', 'category' => 'Frontend', 'required_skills' => ['HTML', 'JavaScript'], 'expected_outcome' => 'Input field controls increment amount.'],
                    ['title' => 'Prevent Negative', 'description' => 'Validation logic.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Counter stops at 0.'],
                    ['title' => 'Keyboard Shortcuts', 'description' => 'Use arrow keys.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Up/Down arrows change count.'],
                ]
            ],
            // 23. Simple To-Do List (DOM Manipulation)
            [
                'title' => 'Simple To-Do List',
                'description' => 'Build a list where you can add and remove items. A classic beginner project to master JavaScript events.',
                'difficulty_level' => 'beginner',
                'skills' => ['HTML', 'CSS', 'JavaScript'],
                'tasks' => [
                    ['title' => 'Input Interface', 'description' => 'Create an input field and an "Add" button.', 'category' => 'Frontend', 'required_skills' => ['HTML', 'CSS'], 'expected_outcome' => 'Input form visible on page.'],
                    ['title' => 'Add Item Logic', 'description' => 'Add the input text to the list when clicked.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'New items appear in the UL/OL.'],
                    ['title' => 'Delete Item Logic', 'description' => 'Allow users to remove items.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Clicking "X" removes the item from the DOM.'],
                    ['title' => 'Mark as Done', 'description' => 'Toggle completion status.', 'category' => 'Frontend', 'required_skills' => ['CSS', 'JavaScript'], 'expected_outcome' => 'Clicking item strikes through text.'],
                    ['title' => 'Local Storage', 'description' => 'Save list.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Data persists on reload.'],
                    ['title' => 'Edit Item', 'description' => 'Modify text.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Double click to edit.'],
                ]
            ],
            // 24. Login Page UI (Forms & CSS)
            [
                'title' => 'Login Page UI',
                'description' => 'Design a beautiful login page. Focus on form styling, input states, and visual design.',
                'difficulty_level' => 'beginner',
                'skills' => ['HTML', 'CSS'],
                'tasks' => [
                    ['title' => 'Form Structure', 'description' => 'Create the form with email and password inputs.', 'category' => 'Frontend', 'required_skills' => ['HTML'], 'expected_outcome' => 'Semantic form with proper input types.'],
                    ['title' => 'Visual Styling', 'description' => 'Style the form with shadows, rounded corners, and colors.', 'category' => 'Frontend', 'required_skills' => ['CSS'], 'expected_outcome' => 'Modern looking card layout.'],
                    ['title' => 'Input States', 'description' => 'Style focus and hover states for better UX.', 'category' => 'Frontend', 'required_skills' => ['CSS'], 'expected_outcome' => 'Inputs change border color on focus.'],
                    ['title' => 'Password Visibility', 'description' => 'Toggle show/hide.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Eye icon toggles input type.'],
                    ['title' => 'Form Validation', 'description' => 'Check email format.', 'category' => 'Frontend', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Error message on invalid email.'],
                    ['title' => 'Social Login Buttons', 'description' => 'Add Google/Facebook buttons.', 'category' => 'Frontend', 'required_skills' => ['CSS'], 'expected_outcome' => 'Styled buttons with icons.'],
                ]
            ],
        ];


        foreach ($projects as $projectData) {
            $project = Project::create([
                'title' => $projectData['title'],
                'description' => $projectData['description'],
                'difficulty_level' => $projectData['difficulty_level'],
            ]);

            // Attach Skills
            foreach ($projectData['skills'] as $skillName) {
                $skill = Skill::where('name', 'LIKE', "%$skillName%")->first();
                if ($skill) {
                    $project->skills()->attach($skill->id);
                }
            }

            // Create Tasks
            foreach ($projectData['tasks'] as $taskData) {
                $task = Task::create([
                    'project_id' => $project->id,
                    'title' => $taskData['title'],
                    'description' => $taskData['description'],
                    'category' => $taskData['category'],
                ]);

                // Attach Required Skills to Task
                if (isset($taskData['required_skills'])) {
                    foreach ($taskData['required_skills'] as $skillName) {
                        $skill = Skill::where('name', 'LIKE', "%$skillName%")->first();
                        if ($skill) {
                            $task->skills()->attach($skill->id);
                        }
                    }
                }

                // Update Expected Outcome
                if (isset($taskData['expected_outcome'])) {
                    $task->update(['expected_outcome' => $taskData['expected_outcome']]);
                }
            }
        }
    }
}
