# SimuLearn - AI-Powered Industry Simulation Platform

SimuLearn is an intelligent, personalized learning platform designed to bridge the gap between academic theory and industry application. It functions as a **Virtual Industry Simulator**, using AI to act as a "Senior Project Manager" that guides students through realistic software development lifecycles.

## 🚧 Project Status: Under Development

**Overall Progress:** 40%
`████████████████████████████████████████░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░`

> **Note:** This is the **MVP (Minimum Viable Product)** version. All features listed below are part of the initial development phase and will be enhanced in future updates.

### 📅 Detailed Roadmap

#### **Phase 0: Foundation & Setup** (✅ Completed)

-   [x] **Project Initialization**: Laravel 10 + React/Inertia setup.
-   [x] **Database Architecture**: Initial schema design for Users, Skills, and Projects.
-   [x] **Landing Page**: Responsive design with "Get Started" call-to-action.
-   [x] **Environment Configuration**: CI/CD basics and local dev environment setup.

#### **Phase 1: User Onboarding & Profiling** (✅ Completed)

-   [x] **Authentication System**: Secure Login/Register flow (Laravel Breeze/Sanctum).
-   [x] **Skill Profiling Wizard**: Multi-step form to capture user tech stack.
-   [x] **AI Bio Summarization**: Integration with Google Gemini to generate professional summaries.
-   [x] **User Dashboard**: Personalized dashboard with stats and profile management.

#### **Phase 2: Data Intelligence & Matching** (✅ Completed)

-   [x] **Project Database**: Seeding 24 comprehensive simulation projects across 3 difficulty tiers.
-   [x] **Granular Task Structure**: Projects now feature tiered task lists (Beginner: 6+, Intermediate: 12+, Advanced: 18+) to guide users from setup to mastery.
-   [x] **Matching Algorithm**: Logic to recommend projects based on user skill overlap and difficulty preference.
-   [x] **Dashboard Recommendations**: Dynamic UI to display "Best Match" simulations.
-   [x] **Project Filtering**: Filter projects by difficulty (Beginner, Intermediate, Advanced).

#### **Phase 3: The Simulation Core** (🚧 In Progress)

-   [ ] **Workspace Interface**: The main "IDE-like" view for working on projects.
-   [ ] **Task Navigation (DAG)**: Interactive graph (React Flow) showing task dependencies.
-   [ ] **Task Detail View**: Markdown-rendered instructions, resources, and acceptance criteria.
-   [ ] **Task Simulation**: Detailed instructions and scenario simulation (Pending).
-   [ ] **Task Submission**: File upload or text input for task deliverables (Pending).
-   [ ] **Progress Tracking**: State management for locked/unlocked/completed tasks.

#### **Phase 4: Evaluation & Feedback Loop** (⏳ Pending)

-   [ ] **Task Evaluation**: Automated analysis of user submissions using LLMs.
-   [ ] **Performance Scoring**: XP/Points calculation based on code quality and efficiency.
-   [ ] **Feedback Engine**: Generating constructive, specific feedback for improvements.
-   [ ] **Gamification**: Badges and achievements for milestones.
-   [ ] **Career Analytics**: Charts showing skill growth over time.

## 🚀 Core Philosophy

Unlike traditional e-learning platforms that deliver static content, SimuLearn delivers **experience**. It operates on the logic that students learn best when placed in a simulated work environment where tasks are unlocked based on competency, simulating the workflow of a Junior Developer working under a Technical Lead.

## 🌟 Key Features

### 1. Intelligent Project Matching (The Interview)

-   **Input:** Students provide specific skills (e.g., "React", "Laravel") and a free-text description of their confidence level.
-   **AI Logic:** The system parses this input to create a "User Skill Profile" and matches it against available projects.
-   **Output:** A recommended **"Sweet Spot" Project** that utilizes existing skills while introducing manageable new challenges.

### 2. Guided Task Breakdown (The Simulation)

-   **DAG Workflow:** Projects are structured as **Directed Acyclic Graphs**.
-   **Dependency Management:** Future tasks are "locked" until prerequisites are met (e.g., you cannot "Build API" before "Design Database").
-   **Visual Interface:** An interactive node-based graph (powered by React Flow) visualizes the project roadmap.

### 3. AI Evaluation & Feedback (The Code Review)

-   **Submission:** Students submit code or solutions for specific tasks.
-   **AI Grading:** The system analyzes the submission for correctness, security, and best practices.
-   **Feedback Loop:** Students receive a score and specific, constructive feedback. Passing a task unlocks the next node in the graph.

### 4. Career Analytics

-   **Tracking:** The system tracks performance across categories (Frontend, Backend, DevOps, etc.).
-   **Guidance:** Based on performance data, the system suggests tailored career paths (e.g., "Strong aptitude for Backend Engineering").

## 🛠 Tech Stack

-   **Frontend:** React (via Inertia.js), Tailwind CSS, React Flow, Zustand
-   **Backend:** Laravel 10.x, MySQL
-   **AI Integration:** (Planned) OpenAI/Gemini API for code evaluation

## 📦 Installation

1.  **Clone the repository**

    ```bash
    git clone https://github.com/leeyinshen0818/SimuLearn.git
    cd SimuLearn
    ```

2.  **Install Backend Dependencies**

    ```bash
    composer install
    ```

3.  **Install Frontend Dependencies**

    ```bash
    npm install
    ```

4.  **Environment Setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    -   Configure your database credentials in `.env`.

5.  **Run Migrations**

    ```bash
    php artisan migrate
    ```

6.  **Start Development Servers**
    -   Terminal 1: `php artisan serve`
    -   Terminal 2: `npm run dev`

## 📄 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
