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
        $projects = [
            [
                'title' => 'E-commerce API Integration',
                'description' => 'Build a robust RESTful API for an e-commerce platform. You will handle product management, shopping cart functionality, and order processing. This simulation focuses on backend logic, database design, and API security.',
                'difficulty_level' => 'intermediate',
                'skills' => ['Laravel', 'PHP', 'MySQL', 'API Development'],
                'tasks' => [
                    ['title' => 'Database Schema Design', 'description' => 'Design the ERD for products, users, orders, and cart items.', 'category' => 'Database'],
                    ['title' => 'Product API Endpoints', 'description' => 'Create CRUD endpoints for managing products.', 'category' => 'Backend'],
                    ['title' => 'Authentication Setup', 'description' => 'Implement JWT or Sanctum authentication for users.', 'category' => 'Security'],
                    ['title' => 'Shopping Cart Logic', 'description' => 'Implement add-to-cart, update quantity, and remove item features.', 'category' => 'Backend'],
                    ['title' => 'Order Processing', 'description' => 'Handle checkout process and transaction recording.', 'category' => 'Backend'],
                ]
            ],
            [
                'title' => 'Real-time Chat Application',
                'description' => 'Develop a real-time chat application using WebSockets. Users should be able to join rooms, send messages instantly, and see online status. This project combines frontend reactivity with backend broadcasting.',
                'difficulty_level' => 'advanced',
                'skills' => ['React', 'Laravel', 'WebSockets', 'JavaScript'],
                'tasks' => [
                    ['title' => 'WebSocket Server Setup', 'description' => 'Configure Laravel Reverb or Pusher for broadcasting.', 'category' => 'DevOps'],
                    ['title' => 'Chat UI Component', 'description' => 'Build the chat window interface using React.', 'category' => 'Frontend'],
                    ['title' => 'Message Broadcasting', 'description' => 'Implement backend events to broadcast messages to channels.', 'category' => 'Backend'],
                    ['title' => 'Private Messaging', 'description' => 'Enable one-on-one private chat functionality.', 'category' => 'Full Stack'],
                    ['title' => 'Online Status Indicator', 'description' => 'Track and display user online/offline status.', 'category' => 'Real-time'],
                ]
            ],
            [
                'title' => 'Task Management System',
                'description' => 'Create a Trello-like task management board. Users can create boards, lists, and cards. Drag and drop functionality is a key feature. Focus on complex state management and database relationships.',
                'difficulty_level' => 'intermediate',
                'skills' => ['React', 'Laravel', 'JavaScript', 'Database Design'],
                'tasks' => [
                    ['title' => 'Board & List Structure', 'description' => 'Set up database models for Boards, Lists, and Cards.', 'category' => 'Database'],
                    ['title' => 'Drag and Drop UI', 'description' => 'Implement drag-and-drop for cards using a library like dnd-kit.', 'category' => 'Frontend'],
                    ['title' => 'Card Details Modal', 'description' => 'Create a modal to edit card details, assign members, and set due dates.', 'category' => 'Frontend'],
                    ['title' => 'API Integration', 'description' => 'Connect the frontend board to backend API endpoints.', 'category' => 'Full Stack'],
                ]
            ],
            [
                'title' => 'Personal Portfolio Website',
                'description' => 'Design and build a responsive personal portfolio website to showcase your projects and skills. This project focuses on HTML5, CSS3, and modern responsive design principles.',
                'difficulty_level' => 'beginner',
                'skills' => ['HTML', 'CSS', 'JavaScript', 'Responsive Design'],
                'tasks' => [
                    ['title' => 'Wireframing & Layout', 'description' => 'Plan the structure of your portfolio pages.', 'category' => 'Design'],
                    ['title' => 'Hero Section', 'description' => 'Create an engaging hero section with a call to action.', 'category' => 'Frontend'],
                    ['title' => 'Project Gallery', 'description' => 'Build a grid layout to display your projects with hover effects.', 'category' => 'Frontend'],
                    ['title' => 'Contact Form', 'description' => 'Create a contact form with client-side validation.', 'category' => 'Frontend'],
                    ['title' => 'Mobile Responsiveness', 'description' => 'Ensure the site looks good on all device sizes.', 'category' => 'CSS'],
                ]
            ],
            [
                'title' => 'Blog Platform with CMS',
                'description' => 'Build a full-featured blog with a Content Management System (CMS). Admins can write, edit, and publish posts. Users can read and comment. Focus on CRUD operations and role-based access control.',
                'difficulty_level' => 'intermediate',
                'skills' => ['PHP', 'Laravel', 'MySQL', 'Blade'],
                'tasks' => [
                    ['title' => 'Admin Dashboard', 'description' => 'Create a secure area for admins to manage content.', 'category' => 'Backend'],
                    ['title' => 'WYSIWYG Editor Integration', 'description' => 'Integrate a rich text editor for writing posts.', 'category' => 'Frontend'],
                    ['title' => 'Post Publishing Workflow', 'description' => 'Implement draft, scheduled, and published states.', 'category' => 'Backend'],
                    ['title' => 'Comment System', 'description' => 'Allow users to comment on posts with moderation features.', 'category' => 'Full Stack'],
                ]
            ],
            [
                'title' => 'Weather Dashboard',
                'description' => 'Create a weather dashboard that fetches data from a third-party API (like OpenWeatherMap). Users can search for cities and see current weather and forecasts. Focus on API consumption and asynchronous JavaScript.',
                'difficulty_level' => 'beginner',
                'skills' => ['JavaScript', 'React', 'API Integration', 'CSS'],
                'tasks' => [
                    ['title' => 'API Key Setup', 'description' => 'Sign up for a weather API and secure your keys.', 'category' => 'Setup'],
                    ['title' => 'Search Component', 'description' => 'Build a search bar to input city names.', 'category' => 'Frontend'],
                    ['title' => 'Data Fetching', 'description' => 'Use fetch or axios to retrieve weather data.', 'category' => 'JavaScript'],
                    ['title' => 'Weather Display', 'description' => 'Design cards to show temperature, humidity, and conditions.', 'category' => 'UI/UX'],
                ]
            ],
            [
                'title' => 'Inventory Management System',
                'description' => 'Develop a system for tracking inventory levels, orders, and sales. Generate reports and alerts for low stock. This project emphasizes complex SQL queries and data visualization.',
                'difficulty_level' => 'advanced',
                'skills' => ['Laravel', 'MySQL', 'Data Analysis', 'Chart.js'],
                'tasks' => [
                    ['title' => 'Inventory Schema', 'description' => 'Design tables for products, suppliers, and transactions.', 'category' => 'Database'],
                    ['title' => 'Stock Movement Logic', 'description' => 'Handle incoming stock and outgoing sales logic.', 'category' => 'Backend'],
                    ['title' => 'Low Stock Alerts', 'description' => 'Implement a notification system for low inventory.', 'category' => 'Backend'],
                    ['title' => 'Reporting Dashboard', 'description' => 'Visualize sales trends and stock levels using charts.', 'category' => 'Frontend'],
                ]
            ],
            [
                'title' => 'Authentication & Authorization Service',
                'description' => 'Build a standalone auth service. Implement registration, login, password reset, email verification, and OAuth (Google/GitHub login). Focus on security best practices.',
                'difficulty_level' => 'intermediate',
                'skills' => ['Security', 'Laravel', 'OAuth', 'PHP'],
                'tasks' => [
                    ['title' => 'User Registration', 'description' => 'Secure registration with validation and hashing.', 'category' => 'Backend'],
                    ['title' => 'Email Verification', 'description' => 'Send verification emails to new users.', 'category' => 'Backend'],
                    ['title' => 'Password Reset Flow', 'description' => 'Implement secure password reset functionality.', 'category' => 'Security'],
                    ['title' => 'Social Login', 'description' => 'Integrate Google and GitHub OAuth providers.', 'category' => 'Integration'],
                ]
            ],
            [
                'title' => 'Social Media Feed',
                'description' => 'Create a social media news feed. Users can post updates, like posts, and follow other users. The feed should be infinite scrolling. Focus on efficient database queries and pagination.',
                'difficulty_level' => 'advanced',
                'skills' => ['React', 'Laravel', 'Database Optimization', 'API'],
                'tasks' => [
                    ['title' => 'Follower System', 'description' => 'Implement many-to-many relationship for followers.', 'category' => 'Database'],
                    ['title' => 'Feed Generation Algorithm', 'description' => 'Query posts from followed users efficiently.', 'category' => 'Backend'],
                    ['title' => 'Infinite Scroll', 'description' => 'Implement infinite loading for the feed on the frontend.', 'category' => 'Frontend'],
                    ['title' => 'Like & Comment Actions', 'description' => 'Handle social interactions on posts.', 'category' => 'Full Stack'],
                ]
            ],
            [
                'title' => 'Hotel Booking System',
                'description' => 'Build a booking engine for a hotel. Users can search for rooms by date, view availability, and make reservations. Admins can manage rooms and bookings. Focus on date handling and booking logic.',
                'difficulty_level' => 'intermediate',
                'skills' => ['Laravel', 'PHP', 'Full Stack', 'Database'],
                'tasks' => [
                    ['title' => 'Room Management', 'description' => 'CRUD operations for room types and pricing.', 'category' => 'Backend'],
                    ['title' => 'Availability Search', 'description' => 'Implement logic to check room availability for date ranges.', 'category' => 'Backend'],
                    ['title' => 'Booking Process', 'description' => 'Handle the reservation flow and status updates.', 'category' => 'Full Stack'],
                    ['title' => 'Calendar View', 'description' => 'Create a calendar view for admins to see bookings.', 'category' => 'Frontend'],
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
                Task::create([
                    'project_id' => $project->id,
                    'title' => $taskData['title'],
                    'description' => $taskData['description'],
                    'category' => $taskData['category'],
                ]);
            }
        }
    }
}
