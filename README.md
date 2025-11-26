# SimuLearn - AI-Powered Industry Simulation Platform

SimuLearn is an intelligent, personalized learning platform designed to bridge the gap between academic theory and industry application. It functions as a **Virtual Industry Simulator**, using AI to act as a "Senior Project Manager" that guides students through realistic software development lifecycles.

## 🚧 Project Status: Under Development

**Overall Progress:** 25%
![Progress](https://geps.dev/progress/25)

| Phase       | Stage                            | Status       |
| :---------- | :------------------------------- | :----------- |
| **Phase 0** | Setup & Landing Page             | ✅ Completed |
| **Phase 1** | User Foundation (Authentication) | ✅ Completed |
| **Phase 2** | Data & Matching                  | ⏳ Pending   |
| **Phase 3** | The Simulation Core              | ⏳ Pending   |
| **Phase 4** | Evaluation Loop                  | ⏳ Pending   |

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
