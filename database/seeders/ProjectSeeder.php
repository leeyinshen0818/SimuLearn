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
                    ['title' => 'Environment Setup', 'description' => 'Initialize the Laravel project and configure the database.', 'category' => 'DevOps', 'required_skills' => ['Laravel', 'PHP', 'MySQL'], 'expected_outcome' => 'Working Laravel installation connected to MySQL.'],
                    ['title' => 'Database Migration', 'description' => 'Create migrations for products, orders, and users.', 'category' => 'Database', 'required_skills' => ['Laravel', 'MySQL'], 'expected_outcome' => 'Database tables created via artisan migrate.'],
                    ['title' => 'Basic Product API', 'description' => 'Create a simple REST API to list products.', 'category' => 'Backend', 'required_skills' => ['Laravel', 'PHP'], 'expected_outcome' => 'GET /api/products returns JSON list.'],
                    ['title' => 'Shopping Cart Service', 'description' => 'Implement a shopping cart using Redis for temporary storage.', 'category' => 'Backend', 'required_skills' => ['Laravel', 'Redis'], 'expected_outcome' => 'Endpoints to add/remove items from cart.'],
                    ['title' => 'Payment Gateway Integration', 'description' => 'Integrate a mock payment gateway (e.g., Stripe).', 'category' => 'Backend', 'required_skills' => ['Laravel', 'PHP'], 'expected_outcome' => 'Successful payment transaction flow.'],
                    ['title' => 'Email Notification Service', 'description' => 'Set up a queue worker to send emails after order placement.', 'category' => 'Backend', 'required_skills' => ['Laravel', 'Redis'], 'expected_outcome' => 'Emails sent asynchronously via queue.'],

                    // Level 2: Intermediate Features
                    ['title' => 'User Authentication', 'description' => 'Implement JWT or Sanctum authentication.', 'category' => 'Security', 'required_skills' => ['Laravel', 'REST'], 'expected_outcome' => 'Secure endpoints requiring bearer token.'],
                    ['title' => 'Product Catalog Service', 'description' => 'Build a read-heavy service for products with caching.', 'category' => 'Backend', 'required_skills' => ['Laravel', 'MySQL', 'Redis', 'REST'], 'expected_outcome' => 'Laravel API with Redis caching for product endpoints.'],
                    ['title' => 'Admin Dashboard API', 'description' => 'Create API endpoints for admin management of products and orders.', 'category' => 'Backend', 'required_skills' => ['Laravel', 'PHP'], 'expected_outcome' => 'Admin-only endpoints protected by middleware.'],
                    ['title' => 'Search Service', 'description' => 'Implement full-text search for products using Elasticsearch or Scout.', 'category' => 'Backend', 'required_skills' => ['Laravel', 'MySQL'], 'expected_outcome' => 'Fast search results for product queries.'],
                    ['title' => 'Inventory Management', 'description' => 'Handle stock updates with concurrency control.', 'category' => 'Backend', 'required_skills' => ['Laravel', 'MySQL'], 'expected_outcome' => 'Race conditions prevented during stock deduction.'],
                    ['title' => 'API Gateway Implementation', 'description' => 'Set up an API Gateway to route requests to services.', 'category' => 'DevOps', 'required_skills' => ['Microservices', 'REST'], 'expected_outcome' => 'Single entry point for all microservices.'],

                    // Level 3: Advanced Architecture
                    ['title' => 'Service Architecture Design', 'description' => 'Design the communication protocol between microservices.', 'category' => 'System Design', 'required_skills' => ['Microservices', 'Docker', 'REST', 'gRPC'], 'expected_outcome' => 'Docker Compose file and API specs (OpenAPI/Protobuf).'],
                    ['title' => 'Order Management Service', 'description' => 'Develop a transactional service for orders with async processing.', 'category' => 'Backend', 'required_skills' => ['PHP', 'MySQL', 'Kafka'], 'expected_outcome' => 'PHP service consuming Kafka events for order processing.'],
                    ['title' => 'Centralized Logging', 'description' => 'Aggregate logs from all services into ELK stack.', 'category' => 'DevOps', 'required_skills' => ['Docker', 'Microservices'], 'expected_outcome' => 'Logs visible in Kibana dashboard.'],
                    ['title' => 'Monitoring & Metrics', 'description' => 'Set up Prometheus and Grafana for monitoring.', 'category' => 'DevOps', 'required_skills' => ['Docker', 'Microservices'], 'expected_outcome' => 'Real-time metrics dashboard.'],
                    ['title' => 'CI/CD Pipeline Setup', 'description' => 'Automate testing and deployment.', 'category' => 'DevOps', 'required_skills' => ['Docker'], 'expected_outcome' => 'Pipeline runs tests on commit.'],
                    ['title' => 'Load Testing & Optimization', 'description' => 'Simulate high traffic and optimize performance.', 'category' => 'DevOps', 'required_skills' => ['PHP', 'MySQL'], 'expected_outcome' => 'Report on system bottlenecks and fixes.'],
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
                    ['title' => 'Frontend Setup', 'description' => 'Initialize the React application.', 'category' => 'Frontend', 'required_skills' => ['React', 'JavaScript'], 'expected_outcome' => 'React app running with basic layout.'],
                    ['title' => 'Static Chat UI', 'description' => 'Build the chat interface with mock data.', 'category' => 'Frontend', 'required_skills' => ['React', 'CSS'], 'expected_outcome' => 'Visual chat window with message bubbles.'],
                    ['title' => 'Node.js API', 'description' => 'Create a basic Express/NestJS API for user login.', 'category' => 'Backend', 'required_skills' => ['Node.js'], 'expected_outcome' => 'POST /login endpoint returning token.'],
                    ['title' => 'User Presence', 'description' => 'Implement online/offline status indicators.', 'category' => 'Backend', 'required_skills' => ['Node.js', 'React'], 'expected_outcome' => 'UI updates when users connect/disconnect.'],
                    ['title' => 'Typing Indicators', 'description' => 'Show when a user is typing.', 'category' => 'Frontend', 'required_skills' => ['React', 'Node.js'], 'expected_outcome' => '"User is typing..." message appears.'],
                    ['title' => 'Message History Persistence', 'description' => 'Store chat history in MongoDB.', 'category' => 'Database', 'required_skills' => ['MongoDB', 'Node.js'], 'expected_outcome' => 'Messages persist after page reload.'],

                    // Level 2: Intermediate Features
                    ['title' => 'Chat UI Component', 'description' => 'Connect UI to Redux store.', 'category' => 'Frontend', 'required_skills' => ['React', 'Redux'], 'expected_outcome' => 'React components for chat window and message list connected to Redux store.'],
                    ['title' => 'File Sharing Support', 'description' => 'Allow users to send images and files.', 'category' => 'Backend', 'required_skills' => ['Node.js', 'React'], 'expected_outcome' => 'File upload and display in chat.'],
                    ['title' => 'Group Channels', 'description' => 'Create channels for multiple users.', 'category' => 'Backend', 'required_skills' => ['Node.js', 'MongoDB'], 'expected_outcome' => 'Users can join/leave channels.'],
                    ['title' => 'Push Notifications', 'description' => 'Notify users of new messages.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'Browser notifications for incoming messages.'],
                    ['title' => 'Voice/Video Call Integration', 'description' => 'Add WebRTC support for calls.', 'category' => 'Frontend', 'required_skills' => ['React', 'JavaScript'], 'expected_outcome' => 'P2P video call functionality.'],
                    ['title' => 'Message Encryption', 'description' => 'Implement End-to-End encryption.', 'category' => 'Security', 'required_skills' => ['JavaScript'], 'expected_outcome' => 'Messages encrypted before sending.'],

                    // Level 3: Advanced Architecture
                    ['title' => 'WebSocket Server Setup', 'description' => 'Set up a scalable WebSocket server.', 'category' => 'Backend', 'required_skills' => ['Node.js', 'NestJS', 'Event-Driven Architecture'], 'expected_outcome' => 'NestJS gateway handling connections.'],
                    ['title' => 'Message Queue Integration', 'description' => 'Handle message delivery guarantees.', 'category' => 'Backend', 'required_skills' => ['RabbitMQ', 'Node.js'], 'expected_outcome' => 'RabbitMQ consumer for chat messages.'],
                    ['title' => 'User Profile Management', 'description' => 'Allow users to update avatars and status.', 'category' => 'Frontend', 'required_skills' => ['React', 'Node.js'], 'expected_outcome' => 'Profile settings page.'],
                    ['title' => 'Search Messages', 'description' => 'Full-text search for chat history.', 'category' => 'Database', 'required_skills' => ['MongoDB'], 'expected_outcome' => 'Search bar filtering messages.'],
                    ['title' => 'Scalability: Redis Adapter', 'description' => 'Use Redis adapter for Socket.io scaling.', 'category' => 'Backend', 'required_skills' => ['Node.js', 'Redis'], 'expected_outcome' => 'Multiple server instances communicating.'],
                    ['title' => 'Deployment to Kubernetes', 'description' => 'Deploy the stack to K8s.', 'category' => 'DevOps', 'required_skills' => ['Docker'], 'expected_outcome' => 'Running cluster with load balancer.'],
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
                    ['title' => 'Project Structure', 'description' => 'Set up the Python environment and project folders.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'Virtual environment created and requirements.txt initialized.'],
                    ['title' => 'Basic Scripting', 'description' => 'Write a script to open and display an image.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'OpenCV'], 'expected_outcome' => 'Script that reads an image file.'],
                    ['title' => 'Image Preprocessing', 'description' => 'Prepare images for the model.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'OpenCV'], 'expected_outcome' => 'Python script to resize and normalize images.'],
                    ['title' => 'Simple API', 'description' => 'Create a Hello World FastAPI endpoint.', 'category' => 'Backend', 'required_skills' => ['FastAPI', 'Python'], 'expected_outcome' => 'Running FastAPI server.'],
                    ['title' => 'Data Augmentation Pipeline', 'description' => 'Increase dataset size with transformations.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'TensorFlow'], 'expected_outcome' => 'Script generating rotated/flipped images.'],
                    ['title' => 'Model Evaluation Metrics', 'description' => 'Implement accuracy, precision, and recall metrics.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'Scikit-learn'], 'expected_outcome' => 'Evaluation report generation.'],

                    // Level 2: Intermediate Features
                    ['title' => 'Model Training', 'description' => 'Train a CNN model on a dataset.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'TensorFlow', 'Deep Learning'], 'expected_outcome' => 'Trained .h5 model file with >85% accuracy.'],
                    ['title' => 'Prediction API', 'description' => 'Serve the model via a REST API.', 'category' => 'Backend', 'required_skills' => ['FastAPI', 'Python', 'REST'], 'expected_outcome' => 'FastAPI endpoint accepting image uploads and returning predictions.'],
                    ['title' => 'Hyperparameter Tuning', 'description' => 'Optimize model parameters.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'TensorFlow'], 'expected_outcome' => 'Improved model accuracy.'],
                    ['title' => 'Model Versioning', 'description' => 'Track model versions.', 'category' => 'DevOps', 'required_skills' => ['Python'], 'expected_outcome' => 'System to load specific model versions.'],
                    ['title' => 'Batch Prediction Endpoint', 'description' => 'Handle multiple images at once.', 'category' => 'Backend', 'required_skills' => ['FastAPI', 'Python'], 'expected_outcome' => 'API accepting zip or list of images.'],
                    ['title' => 'Frontend Image Upload UI', 'description' => 'Create a React UI for uploading images.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'Drag-and-drop upload zone.'],

                    // Level 3: Advanced Architecture
                    ['title' => 'Result Visualization', 'description' => 'Display prediction confidence and heatmaps.', 'category' => 'Frontend', 'required_skills' => ['React', 'D3.js'], 'expected_outcome' => 'Visual representation of model output.'],
                    ['title' => 'User Feedback Loop', 'description' => 'Allow users to correct predictions.', 'category' => 'Backend', 'required_skills' => ['FastAPI', 'Database'], 'expected_outcome' => 'Endpoint to save corrected labels.'],
                    ['title' => 'Dockerize Model Service', 'description' => 'Containerize the application.', 'category' => 'DevOps', 'required_skills' => ['Docker'], 'expected_outcome' => 'Dockerfile for FastAPI app.'],
                    ['title' => 'GPU Acceleration Setup', 'description' => 'Configure CUDA for training.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'TensorFlow'], 'expected_outcome' => 'Training runs on GPU.'],
                    ['title' => 'API Rate Limiting', 'description' => 'Prevent abuse of the API.', 'category' => 'Backend', 'required_skills' => ['FastAPI', 'Redis'], 'expected_outcome' => 'Rate limit headers in response.'],
                    ['title' => 'Model Monitoring', 'description' => 'Detect data drift over time.', 'category' => 'AI/Data', 'required_skills' => ['Python'], 'expected_outcome' => 'Alerts when model performance degrades.'],
                ]
            ],
            // 4. Cross-Platform Fitness App (Mobile stack)
            [
                'title' => 'Cross-Platform Fitness Tracker',
                'description' => 'Create a mobile app to track workouts and diet. Use React Native for cross-platform compatibility and Firebase for the backend.',
                'difficulty_level' => 'intermediate',
                'skills' => ['React Native', 'Firebase', 'TypeScript', 'JavaScript', 'OAuth2'],
                'tasks' => [
                    ['title' => 'UI Mockups', 'description' => 'Design the app screens using standard web technologies first.', 'category' => 'Frontend', 'required_skills' => ['JavaScript', 'CSS'], 'expected_outcome' => 'HTML/CSS mockups of the main screens.'],
                    ['title' => 'App Navigation', 'description' => 'Set up tab and stack navigation.', 'category' => 'Mobile', 'required_skills' => ['React Native', 'TypeScript'], 'expected_outcome' => 'Mobile app shell with working navigation between screens.'],
                    ['title' => 'User Authentication', 'description' => 'Implement secure login and signup.', 'category' => 'Backend', 'required_skills' => ['Firebase', 'OAuth2'], 'expected_outcome' => 'Firebase Auth integration with Google Sign-In.'],
                    ['title' => 'Workout Logging', 'description' => 'Create forms to log exercises.', 'category' => 'Mobile', 'required_skills' => ['React Native', 'JavaScript'], 'expected_outcome' => 'Screens to input sets, reps, and weights.'],
                    ['title' => 'Exercise Database', 'description' => 'Populate a list of exercises.', 'category' => 'Database', 'required_skills' => ['Firebase'], 'expected_outcome' => 'Searchable list of exercises.'],
                    ['title' => 'Progress Charts', 'description' => 'Visualize workout progress.', 'category' => 'Frontend', 'required_skills' => ['React Native'], 'expected_outcome' => 'Line charts showing strength gains.'],
                    ['title' => 'Profile Settings', 'description' => 'Manage user preferences.', 'category' => 'Frontend', 'required_skills' => ['React Native'], 'expected_outcome' => 'Settings screen for units and notifications.'],
                    ['title' => 'Offline Support', 'description' => 'Cache data locally.', 'category' => 'Mobile', 'required_skills' => ['React Native'], 'expected_outcome' => 'App works without internet connection.'],
                    ['title' => 'Social Sharing', 'description' => 'Share workouts to social media.', 'category' => 'Mobile', 'required_skills' => ['React Native'], 'expected_outcome' => 'Share sheet integration.'],
                    ['title' => 'Push Notifications', 'description' => 'Remind users to workout.', 'category' => 'Mobile', 'required_skills' => ['Firebase'], 'expected_outcome' => 'Scheduled local notifications.'],
                    ['title' => 'Dark Mode Support', 'description' => 'Implement theming.', 'category' => 'Frontend', 'required_skills' => ['React Native', 'CSS'], 'expected_outcome' => 'App adapts to system theme.'],
                    ['title' => 'App Store Deployment Prep', 'description' => 'Prepare assets for store submission.', 'category' => 'DevOps', 'required_skills' => ['React Native'], 'expected_outcome' => 'Signed APK/IPA files.'],
                ]
            ],
            // 5. Secure Banking API (Go/Security stack)
            [
                'title' => 'Secure Banking API',
                'description' => 'Design a high-security API for financial transactions. Focus on concurrency, data integrity, and secure coding practices.',
                'difficulty_level' => 'advanced',
                'skills' => ['Go', 'PostgreSQL', 'Docker', 'Linux', 'Symfony', 'OAuth2', 'JWT', 'gRPC'],
                'tasks' => [
                    ['title' => 'Database Schema', 'description' => 'Design the database schema for users and transactions.', 'category' => 'Database', 'required_skills' => ['MySQL'], 'expected_outcome' => 'SQL script creating tables with proper constraints.'],
                    ['title' => 'Transaction Service', 'description' => 'Handle money transfers with ACID guarantees.', 'category' => 'Backend', 'required_skills' => ['Go', 'PostgreSQL', 'gRPC'], 'expected_outcome' => 'Go gRPC service using database transactions.'],
                    ['title' => 'Security Layer', 'description' => 'Implement robust authentication.', 'category' => 'Security', 'required_skills' => ['OAuth2', 'JWT'], 'expected_outcome' => 'Middleware validating JWT tokens and scopes.'],
                    ['title' => 'Containerization', 'description' => 'Dockerize the application.', 'category' => 'DevOps', 'required_skills' => ['Docker', 'Linux'], 'expected_outcome' => 'Optimized Dockerfile and secure container configuration.'],
                    ['title' => 'Account Management API', 'description' => 'CRUD for bank accounts.', 'category' => 'Backend', 'required_skills' => ['Go', 'PostgreSQL'], 'expected_outcome' => 'API to create and manage accounts.'],
                    ['title' => 'Audit Logging', 'description' => 'Track all user actions.', 'category' => 'Security', 'required_skills' => ['Go'], 'expected_outcome' => 'Immutable log of all API calls.'],
                    ['title' => 'Rate Limiting', 'description' => 'Prevent brute force attacks.', 'category' => 'Security', 'required_skills' => ['Go', 'Redis'], 'expected_outcome' => 'Token bucket algorithm implementation.'],
                    ['title' => 'Two-Factor Authentication', 'description' => 'Implement TOTP.', 'category' => 'Security', 'required_skills' => ['Go'], 'expected_outcome' => 'QR code generation and code verification.'],
                    ['title' => 'Fraud Detection Rules', 'description' => 'Flag suspicious transactions.', 'category' => 'Backend', 'required_skills' => ['Go'], 'expected_outcome' => 'Logic to freeze accounts on large transfers.'],
                    ['title' => 'Currency Conversion Service', 'description' => 'Handle multi-currency accounts.', 'category' => 'Backend', 'required_skills' => ['Go'], 'expected_outcome' => 'Integration with external exchange rate API.'],
                    ['title' => 'API Documentation', 'description' => 'Generate Swagger docs.', 'category' => 'Backend', 'required_skills' => ['Go'], 'expected_outcome' => 'Interactive API documentation page.'],
                    ['title' => 'Integration Testing', 'description' => 'Test end-to-end flows.', 'category' => 'DevOps', 'required_skills' => ['Go'], 'expected_outcome' => 'Test suite covering transfer scenarios.'],
                    ['title' => 'Secret Management', 'description' => 'Securely store credentials.', 'category' => 'Security', 'required_skills' => ['Linux'], 'expected_outcome' => 'Integration with HashiCorp Vault or similar.'],
                    ['title' => 'Mutual TLS', 'description' => 'Secure service-to-service comms.', 'category' => 'Security', 'required_skills' => ['Go'], 'expected_outcome' => 'mTLS configuration for gRPC.'],
                    ['title' => 'Database Replication', 'description' => 'Set up read replicas.', 'category' => 'Database', 'required_skills' => ['PostgreSQL'], 'expected_outcome' => 'Primary-Replica setup.'],
                    ['title' => 'Kubernetes Deployment', 'description' => 'Deploy to K8s.', 'category' => 'DevOps', 'required_skills' => ['Kubernetes'], 'expected_outcome' => 'Helm charts for the application.'],
                    ['title' => 'Vulnerability Scanning', 'description' => 'Scan dependencies for CVEs.', 'category' => 'Security', 'required_skills' => ['Linux'], 'expected_outcome' => 'CI step running trivy or similar.'],
                    ['title' => 'Performance Profiling', 'description' => 'Optimize Go code.', 'category' => 'Backend', 'required_skills' => ['Go'], 'expected_outcome' => 'pprof analysis report.'],
                ]
            ],
            // 6. Social Media Sentiment Analysis (Data Science stack)
            [
                'title' => 'Social Media Sentiment Analysis',
                'description' => 'Analyze social media posts to determine public sentiment. Use NLP techniques and visualize the results.',
                'difficulty_level' => 'intermediate',
                'skills' => ['Python', 'Pandas', 'Scikit-learn', 'Django', 'PyTorch', 'Machine Learning', 'GraphQL'],
                'tasks' => [
                    ['title' => 'Data Collection', 'description' => 'Ingest data from CSV or APIs.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'Pandas'], 'expected_outcome' => 'Cleaned DataFrame ready for analysis.'],
                    ['title' => 'Sentiment Model', 'description' => 'Train a classifier for positive/negative sentiment.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'Scikit-learn', 'Machine Learning'], 'expected_outcome' => 'Trained classifier model.'],
                    ['title' => 'Advanced NLP', 'description' => 'Use deep learning for nuance.', 'category' => 'AI/Data', 'required_skills' => ['PyTorch'], 'expected_outcome' => 'PyTorch LSTM model.'],
                    ['title' => 'Dashboard View', 'description' => 'Display trends over time.', 'category' => 'Backend', 'required_skills' => ['Django', 'GraphQL'], 'expected_outcome' => 'Django Graphene schema for sentiment data.'],
                    ['title' => 'Data Cleaning Pipeline', 'description' => 'Automate text preprocessing.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'Pandas'], 'expected_outcome' => 'Script removing stop words and punctuation.'],
                    ['title' => 'Exploratory Data Analysis', 'description' => 'Visualize data distribution.', 'category' => 'AI/Data', 'required_skills' => ['Python'], 'expected_outcome' => 'Jupyter notebook with histograms and word clouds.'],
                    ['title' => 'Topic Modeling', 'description' => 'Identify common themes.', 'category' => 'AI/Data', 'required_skills' => ['Python', 'Machine Learning'], 'expected_outcome' => 'LDA model outputting topics.'],
                    ['title' => 'Real-time Twitter Stream', 'description' => 'Connect to Twitter API.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'Script consuming live tweets.'],
                    ['title' => 'API for Sentiment Analysis', 'description' => 'Expose model via API.', 'category' => 'Backend', 'required_skills' => ['Django'], 'expected_outcome' => 'REST endpoint for text analysis.'],
                    ['title' => 'User Authentication', 'description' => 'Secure the dashboard.', 'category' => 'Backend', 'required_skills' => ['Django'], 'expected_outcome' => 'Login page for analysts.'],
                    ['title' => 'Export Reports', 'description' => 'Generate PDF reports.', 'category' => 'Backend', 'required_skills' => ['Python'], 'expected_outcome' => 'Downloadable PDF with charts.'],
                    ['title' => 'Model Deployment', 'description' => 'Deploy model to production.', 'category' => 'DevOps', 'required_skills' => ['Docker'], 'expected_outcome' => 'Docker container serving the model.'],
                ]
            ],
            // 7. Cloud-Native File Storage (AWS/Node stack)
            [
                'title' => 'Cloud-Native File Storage',
                'description' => 'Build a Dropbox clone using cloud services. Handle file uploads, storage, and sharing securely.',
                'difficulty_level' => 'advanced',
                'skills' => ['AWS', 'Node.js', 'React', 'MongoDB', 'Microservices'],
                'tasks' => [
                    ['title' => 'Frontend Manager', 'description' => 'UI for file management.', 'category' => 'Frontend', 'required_skills' => ['React', 'JavaScript'], 'expected_outcome' => 'React file explorer component.'],
                    ['title' => 'S3 Integration', 'description' => 'Implement file upload to AWS S3.', 'category' => 'DevOps', 'required_skills' => ['AWS', 'Node.js'], 'expected_outcome' => 'Node.js service generating presigned URLs for uploads.'],
                    ['title' => 'File Metadata Service', 'description' => 'Store file info in database.', 'category' => 'Backend', 'required_skills' => ['MongoDB', 'Microservices'], 'expected_outcome' => 'Standalone microservice for file metadata.'],
                    ['title' => 'User Authentication', 'description' => 'Secure access to files.', 'category' => 'Security', 'required_skills' => ['Node.js'], 'expected_outcome' => 'JWT based auth.'],
                    ['title' => 'Folder Structure Support', 'description' => 'Nested directories.', 'category' => 'Backend', 'required_skills' => ['MongoDB'], 'expected_outcome' => 'Recursive file tree structure.'],
                    ['title' => 'File Sharing', 'description' => 'Generate public links.', 'category' => 'Backend', 'required_skills' => ['Node.js'], 'expected_outcome' => 'Time-limited shareable URLs.'],
                    ['title' => 'Image Thumbnail Generation', 'description' => 'Process images on upload.', 'category' => 'DevOps', 'required_skills' => ['AWS'], 'expected_outcome' => 'Lambda function creating thumbnails.'],
                    ['title' => 'File Versioning', 'description' => 'Keep history of changes.', 'category' => 'Backend', 'required_skills' => ['AWS'], 'expected_outcome' => 'S3 versioning enabled.'],
                    ['title' => 'Drag and Drop Uploads', 'description' => 'Improve UX.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'Dropzone component.'],
                    ['title' => 'Storage Quota Management', 'description' => 'Limit user storage.', 'category' => 'Backend', 'required_skills' => ['MongoDB'], 'expected_outcome' => 'Logic to reject uploads if quota exceeded.'],
                    ['title' => 'Trash Bin', 'description' => 'Soft delete files.', 'category' => 'Backend', 'required_skills' => ['MongoDB'], 'expected_outcome' => 'Restore functionality.'],
                    ['title' => 'Search Files', 'description' => 'Find files by name.', 'category' => 'Backend', 'required_skills' => ['MongoDB'], 'expected_outcome' => 'Search API.'],
                    ['title' => 'File Preview', 'description' => 'View docs in browser.', 'category' => 'Frontend', 'required_skills' => ['React'], 'expected_outcome' => 'PDF/Image viewer.'],
                    ['title' => 'Multipart Uploads', 'description' => 'Handle large files.', 'category' => 'Backend', 'required_skills' => ['AWS'], 'expected_outcome' => 'Chunked upload support.'],
                    ['title' => 'CDN Integration', 'description' => 'Fast global access.', 'category' => 'DevOps', 'required_skills' => ['AWS'], 'expected_outcome' => 'CloudFront distribution.'],
                    ['title' => 'Data Encryption', 'description' => 'Encrypt at rest.', 'category' => 'Security', 'required_skills' => ['AWS'], 'expected_outcome' => 'KMS integration.'],
                    ['title' => 'Access Control Lists', 'description' => 'Granular permissions.', 'category' => 'Security', 'required_skills' => ['MongoDB'], 'expected_outcome' => 'Read/Write permission logic.'],
                    ['title' => 'Activity Log', 'description' => 'Track file access.', 'category' => 'Backend', 'required_skills' => ['MongoDB'], 'expected_outcome' => 'Audit trail.'],
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
