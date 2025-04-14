# FreelaDesk – V1.0

FreelaDesk is a lightweight project and task management system built for small teams and individuals who want a clean and simple way to organize their work. Think of it as a stripped-down version of Jira or ClickUp focused on speed, clarity, and ease of use.

## ✨ Features in V1.0

- User authentication (Login/Register)
- Projects management (Create, Update, Delete)
- Task management under each project
- Task statuses (To Do, In Progress, Done)
- Task assignment to users
- Due dates and priorities
- Comments on tasks (basic communication)
- Basic dashboard for task overview
- Notifications (optional or future-ready)

## 🛠️ Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Nuxt.js (separate repo)
- **Database**: MySQL
- **Auth**: Sanctum (API token-based)
- **Deployment**: Shared hosting (backend), Vercel (frontend)

## 🚀 Getting Started (Backend)

```bash
git clone git@github.com:RahmatUllah-github/freeladesk-backend.git
cd freeladesk-backend
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```


### 🧠 V2.0 – Collaborative Workspace Expansion

# FreelaDesk – V2.0

V2.0 is a step forward into building a more collaborative workspace, adding features that improve workflow visibility and communication among team members.

## 🔥 Features in V2.0

- Sub-tasks and checklists
- File attachments to tasks
- Activity logs
- Project/user roles (Admin, Member, Viewer)
- Workspace/team switcher
- Real-time updates with Pusher or Laravel Echo
- Tagging & filtering tasks
- Improved notifications
- Enhanced dashboard (charts, task load, etc.)

## ⚙️ Stack Improvements

- Websockets for real-time collaboration
- Vuex or Pinia for state management (frontend)
- Advanced Laravel policies for roles
- File uploads via S3 or local storage

## 🚧 Coming Up

This version starts laying the foundation for teams to manage complex projects with clarity and efficiency.

