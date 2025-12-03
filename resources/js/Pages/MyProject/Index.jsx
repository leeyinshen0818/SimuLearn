import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';

const MyProjectIndex = ({ auth, enrolledProjects = [], activeProject, currentTask }) => {

    const [displayedTask, setDisplayedTask] = React.useState(currentTask);
    const [showDeleteModal, setShowDeleteModal] = React.useState(false);
    const [showSubmissionModal, setShowSubmissionModal] = React.useState(false);

    const { data, setData, post, processing, errors, reset } = useForm({
        file: null,
    });

    React.useEffect(() => {
        setDisplayedTask(currentTask);
    }, [currentTask]);

    const submitSolution = (e) => {
        e.preventDefault();
        post(`/tasks/${displayedTask.id}/submit`, {
            onSuccess: () => {
                setShowSubmissionModal(false);
                reset();
            },
        });
    };

    // Helper to calculate progress percentage
    const calculateProgress = (project) => {
        // If progress is stored in pivot, use it. Otherwise calculate from tasks if available.
        // The controller passes enrolledProjects with pivot, but tasks might not be loaded for all.
        // Let's rely on pivot.progress if updated, or just show 0 if not.
        // For the active project, we have tasks loaded.
        if (activeProject && project.id === activeProject.id && activeProject.tasks) {
            const total = activeProject.tasks.length;
            if (total === 0) return 0;
            const completed = activeProject.tasks.filter(t =>
                t.user_tasks && t.user_tasks.length > 0 && t.user_tasks[0].status === 'completed'
            ).length;
            return Math.round((completed / total) * 100);
        }
        return project.pivot?.progress || 0;
    };

    return (
        <div className="min-h-screen bg-gray-100">
            <Head title="My Simulation" />

            <nav className="bg-white border-b border-gray-200 shadow-sm">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-16">
                        <div className="flex items-center">
                            <Link href="/dashboard" className="flex items-center text-gray-500 hover:text-gray-700">
                                <svg className="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to Dashboard
                            </Link>
                            <span className="mx-4 text-gray-300">|</span>
                            <h1 className="text-xl font-bold text-gray-900">My Simulation Workspace</h1>
                        </div>
                        <div className="flex items-center">
                            <div className="text-sm text-gray-500">
                                Welcome, <span className="font-medium text-gray-900">{auth.user.name}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div className="flex flex-col lg:flex-row gap-8">

                    {/* Sidebar: Project Switcher */}
                    <div className="w-full lg:w-1/4">
                        <div className="bg-white shadow rounded-lg overflow-hidden">
                            <div className="px-4 py-5 border-b border-gray-200 bg-gray-50">
                                <h3 className="text-lg font-medium text-gray-900">My Projects</h3>
                            </div>
                            <ul className="divide-y divide-gray-200">
                                {enrolledProjects.map((project) => {
                                    const isActive = project.id === activeProject.id;
                                    return (
                                        <li key={project.id} className={`hover:bg-gray-50 transition-colors ${isActive ? 'bg-indigo-50 border-l-4 border-indigo-500' : ''}`}>
                                            <Link
                                                href={`/my-projects?project_id=${project.id}`}
                                                className="block px-4 py-4"
                                            >
                                                <div className="flex justify-between items-center mb-1">
                                                    <p className={`text-sm font-medium ${isActive ? 'text-indigo-700' : 'text-gray-900'}`}>
                                                        {project.title}
                                                    </p>
                                                    {isActive && <span className="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">Active</span>}
                                                </div>
                                                <div className="mt-2">
                                                    <div className="flex justify-between text-xs text-gray-500 mb-1">
                                                        <span>Progress</span>
                                                        <span>{calculateProgress(project)}%</span>
                                                    </div>
                                                    <div className="w-full bg-gray-200 rounded-full h-1.5">
                                                        <div
                                                            className="bg-indigo-600 h-1.5 rounded-full"
                                                            style={{ width: `${calculateProgress(project)}%` }}
                                                        ></div>
                                                    </div>
                                                </div>
                                            </Link>
                                        </li>
                                    );
                                })}
                                {enrolledProjects.length === 0 && (
                                    <li className="px-4 py-4 text-sm text-gray-500 text-center">
                                        No active projects.
                                    </li>
                                )}
                            </ul>
                            <div className="bg-gray-50 px-4 py-3 border-t border-gray-200 text-center">
                                <Link href="/projects" className="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                    + Enroll in new project
                                </Link>
                            </div>
                        </div>
                    </div>

                    {/* Main Content: Active Simulation */}
                    <div className="w-full lg:w-3/4 space-y-6">

                        {activeProject ? (
                            <>
                                {/* Project Header */}
                                <div className="bg-white shadow rounded-lg p-6">
                                    <div className="flex justify-between items-start">
                                        <div>
                                            <h2 className="text-2xl font-bold text-gray-900">{activeProject.title}</h2>
                                            <p className="mt-1 text-gray-500">{activeProject.description}</p>
                                        </div>
                                        <div className="text-right">
                                            <span className="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                In Progress
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {/* Current Task Workspace */}
                                {displayedTask ? (
                                    <div className="bg-white shadow rounded-lg overflow-hidden border border-indigo-100">
                                        <div className="bg-indigo-600 px-6 py-4 flex justify-between items-center">
                                            <h3 className="text-lg font-medium text-white flex items-center">
                                                <svg className="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                                {displayedTask.id === currentTask?.id ? 'Current Task: ' : 'Viewing Task: '} {displayedTask.title}
                                            </h3>
                                            <span className="text-indigo-100 text-sm bg-indigo-700 px-2 py-1 rounded">
                                                Step {(activeProject.tasks?.findIndex(t => t.id === displayedTask.id) ?? -1) + 1} of {activeProject.tasks?.length || 0}
                                            </span>
                                        </div>

                                        <div className="p-6 space-y-6">
                                            {/* Scenario Section */}
                                            {displayedTask.scenario && (
                                                <div className="bg-blue-50 border-l-4 border-blue-400 p-4">
                                                    <div className="flex">
                                                        <div className="shrink-0">
                                                            <svg className="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fillRule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clipRule="evenodd" />
                                                            </svg>
                                                        </div>
                                                        <div className="ml-3">
                                                            <h4 className="text-sm font-bold text-blue-800 uppercase tracking-wide">Scenario</h4>
                                                            <p className="text-sm text-blue-700 mt-1">
                                                                {displayedTask.scenario}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            )}

                                            {/* Description */}
                                            <div>
                                                <h4 className="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Task Description</h4>
                                                <div className="prose prose-indigo max-w-none text-gray-900">
                                                    <p>{displayedTask.description}</p>
                                                </div>
                                            </div>

                                            {/* Expected Outcome */}
                                            <div className="bg-gray-50 p-4 rounded-md">
                                                <h4 className="text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Expected Outcome</h4>
                                                <p className="text-gray-800">{displayedTask.expected_outcome}</p>
                                            </div>

                                            {/* Skills */}
                                            {displayedTask.skills && displayedTask.skills.length > 0 && (
                                                <div>
                                                    <h4 className="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Skills Involved</h4>
                                                    <div className="flex flex-wrap gap-2">
                                                        {displayedTask.skills.map(skill => (
                                                            <span key={skill.id} className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                                {skill.name}
                                                            </span>
                                                        ))}
                                                    </div>
                                                </div>
                                            )}

                                            {/* Action Area */}
                                            <div className="border-t border-gray-200 pt-6 mt-6">
                                                <div className="flex items-center justify-between">
                                                    <div className="text-sm text-gray-500">
                                                        {(() => {
                                                            const userTask = displayedTask.user_tasks && displayedTask.user_tasks[0];
                                                            const isCompleted = userTask && userTask.status === 'completed';
                                                            const submissions = userTask ? userTask.submissions : [];
                                                            const latestSubmission = submissions.length > 0 ? submissions[submissions.length - 1] : null;
                                                            const isPending = latestSubmission && latestSubmission.status === 'pending';

                                                            if (isCompleted) return 'Great job! This task is complete.';
                                                            if (isPending) return 'Your submission is under review.';
                                                            return displayedTask.id === currentTask?.id ? 'Ready to submit your work?' : 'This is a preview of the task.';
                                                        })()}
                                                    </div>
                                                    <div className="flex space-x-3">
                                                        {displayedTask.resource_file_path && (
                                                            <a
                                                                href={`/tasks/${displayedTask.id}/download-resources`}
                                                                className="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                            >
                                                                <svg className="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                </svg>
                                                                Download Resources
                                                            </a>
                                                        )}
                                                        {displayedTask.id === currentTask?.id && (
                                                            (() => {
                                                                const userTask = displayedTask.user_tasks && displayedTask.user_tasks[0];
                                                                const isCompleted = userTask && userTask.status === 'completed';
                                                                const submissions = userTask ? userTask.submissions : [];
                                                                const latestSubmission = submissions.length > 0 ? submissions[submissions.length - 1] : null;
                                                                const isPending = latestSubmission && latestSubmission.status === 'pending';

                                                                if (isCompleted) return null;

                                                                if (isPending) {
                                                                    return (
                                                                        <button
                                                                            className="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 cursor-not-allowed"
                                                                            disabled
                                                                        >
                                                                            <svg className="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                            </svg>
                                                                            Pending Review
                                                                        </button>
                                                                    );
                                                                }

                                                                return (
                                                                    <button
                                                                        className="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                                        onClick={() => setShowSubmissionModal(true)}
                                                                    >
                                                                        Submit
                                                                    </button>
                                                                );
                                                            })()
                                                        )}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ) : (
                                    <div className="bg-white shadow rounded-lg p-12 text-center">
                                        <svg className="mx-auto h-12 w-12 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h3 className="mt-2 text-sm font-medium text-gray-900">Project Completed!</h3>
                                        <p className="mt-1 text-sm text-gray-500">You have finished all tasks in this project.</p>
                                    </div>
                                )}

                                {/* Task List / Roadmap Summary */}
                                <div className="bg-white shadow rounded-lg overflow-hidden">
                                    <div className="px-4 py-5 border-b border-gray-200 sm:px-6">
                                        <h3 className="text-lg leading-6 font-medium text-gray-900">
                                            Project Roadmap
                                        </h3>
                                    </div>
                                    <ul className="divide-y divide-gray-200">
                                        {activeProject.tasks && activeProject.tasks.map((task, index) => {
                                            const userTask = task.user_tasks && task.user_tasks[0];
                                            const submissions = userTask ? userTask.submissions : [];
                                            const latestSubmission = submissions && submissions.length > 0 ? submissions[submissions.length - 1] : null;
                                            const isPending = latestSubmission && latestSubmission.status === 'pending';
                                            const isCompleted = userTask && userTask.status === 'completed';
                                            const isCurrent = currentTask && task.id === currentTask.id;
                                            const isDisplayed = displayedTask && task.id === displayedTask.id;

                                            return (
                                                <li
                                                    key={task.id}
                                                    className={`px-4 py-4 sm:px-6 cursor-pointer hover:bg-gray-50 transition-colors ${isDisplayed ? 'bg-indigo-50' : ''}`}
                                                    onClick={() => setDisplayedTask(task)}
                                                >
                                                    <div className="flex items-center justify-between">
                                                        <div className="flex items-center">
                                                            <div className={`shrink-0 h-8 w-8 flex items-center justify-center rounded-full font-bold text-xs mr-4 ${
                                                                isCompleted ? 'bg-green-100 text-green-800' :
                                                                isPending ? 'bg-yellow-100 text-yellow-800' :
                                                                isCurrent ? 'bg-indigo-600 text-white' :
                                                                'bg-gray-100 text-gray-500'
                                                            }`}>
                                                                {isCompleted ? (
                                                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7"></path></svg>
                                                                ) : isPending ? (
                                                                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                ) : (
                                                                    index + 1
                                                                )}
                                                            </div>
                                                            <div>
                                                                <p className={`text-sm font-medium ${isCurrent ? 'text-indigo-600' : 'text-gray-900'}`}>
                                                                    {task.title}
                                                                </p>
                                                                <p className="text-xs text-gray-500 truncate max-w-md">
                                                                    {task.description}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            {isCompleted ? (
                                                                <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                    Completed
                                                                </span>
                                                            ) : isPending ? (
                                                                <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                    Pending Review
                                                                </span>
                                                            ) : isCurrent ? (
                                                                <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                                    In Progress
                                                                </span>
                                                            ) : (
                                                                <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                                    Pending
                                                                </span>
                                                            )}
                                                        </div>
                                                    </div>
                                                </li>
                                            );
                                        })}
                                    </ul>
                                </div>

                                {/* Danger Zone */}
                                <div className="bg-white shadow rounded-lg overflow-hidden border border-red-200">
                                    <div className="px-4 py-5 border-b border-red-100 bg-red-50 sm:px-6">
                                        <h3 className="text-lg leading-6 font-medium text-red-800">
                                            Danger Zone
                                        </h3>
                                    </div>
                                    <div className="px-4 py-5 sm:p-6">
                                        <div className="sm:flex sm:items-start sm:justify-between">
                                            <div className="max-w-xl text-sm text-gray-500">
                                                <h3 className="text-base font-medium text-gray-900">
                                                    Remove Project
                                                </h3>
                                                <p className="mt-1">
                                                    Once you remove this project, all of your progress and completed tasks will be permanently deleted. This action cannot be undone.
                                                </p>
                                            </div>
                                            <div className="mt-5 sm:mt-0 sm:ml-6 sm:flex sm:shrink-0 sm:items-center">
                                                <button
                                                    type="button"
                                                    className="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto"
                                                    onClick={() => setShowDeleteModal(true)}
                                                >
                                                    Remove Project
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </>
                        ) : (
                            <div className="bg-white shadow rounded-lg p-12 text-center">
                                {enrolledProjects.length === 0 ? (
                                    <>
                                        <svg className="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <h3 className="mt-2 text-lg font-medium text-gray-900">No Active Projects</h3>
                                        <p className="mt-1 text-gray-500">You haven't enrolled in any projects yet.</p>
                                        <div className="mt-6">
                                            <Link href="/projects" className="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                                Browse Projects
                                            </Link>
                                        </div>
                                    </>
                                ) : (
                                    <>
                                        <svg className="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <h3 className="mt-2 text-lg font-medium text-gray-900">Select a Project</h3>
                                        <p className="mt-1 text-gray-500">Please select a project from the sidebar to continue your simulation.</p>
                                    </>
                                )}
                            </div>
                        )}

                    </div>
                </div>
            </div>

            {/* Delete Confirmation Modal */}
            {showDeleteModal && activeProject && (
                <div className="fixed inset-0 z-50 overflow-y-auto" style={{ zIndex: 9999 }} aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div className="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:p-0">
                        <div className="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onClick={() => setShowDeleteModal(false)}></div>

                        <div className="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div className="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div className="sm:flex sm:items-start">
                                    <div className="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <svg className="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <div className="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 className="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                            Remove Project
                                        </h3>
                                        <div className="mt-2">
                                            <p className="text-sm text-gray-500">
                                                Are you sure you want to remove <strong>{activeProject.title}</strong>? All of your progress, completed tasks, and data associated with this project will be permanently removed. This action cannot be undone.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <Link
                                    href={`/my-projects/${activeProject.id}`}
                                    method="delete"
                                    as="button"
                                    className="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
                                    onClick={() => setShowDeleteModal(false)}
                                >
                                    Yes, Remove Project
                                </Link>
                                <button
                                    type="button"
                                    className="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                    onClick={() => setShowDeleteModal(false)}
                                >
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            )}

            {/* Submission Modal */}
            {showSubmissionModal && displayedTask && (
                <div className="fixed inset-0 z-50 overflow-y-auto" style={{ zIndex: 9999 }} aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div className="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:p-0">
                        <div className="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onClick={() => setShowSubmissionModal(false)}></div>

                        <div className="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form onSubmit={submitSolution}>
                                <div className="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div className="sm:flex sm:items-start">
                                        <div className="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <svg className="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                            </svg>
                                        </div>
                                        <div className="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                            <h3 className="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                Submit Solution
                                            </h3>
                                            <div className="mt-2">
                                                <p className="text-sm text-gray-500 mb-4">
                                                    Please upload your solution for <strong>{displayedTask.title}</strong>.
                                                    Your submission should be a single <strong>.zip</strong> file containing all necessary source code and assets.
                                                </p>

                                                <div className="mt-4">
                                                    <label className="block text-sm font-medium text-gray-700">
                                                        Solution File (.zip)
                                                    </label>

                                                    {!data.file ? (
                                                        <div className="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                                            <div className="space-y-1 text-center">
                                                                <svg className="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
                                                                </svg>
                                                                <div className="flex text-sm text-gray-600">
                                                                    <label htmlFor="file-upload" className="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                                        <span>Upload a file</span>
                                                                        <input id="file-upload" name="file-upload" type="file" className="sr-only" accept=".zip" onChange={e => setData('file', e.target.files[0])} />
                                                                    </label>
                                                                    <p className="pl-1">or drag and drop</p>
                                                                </div>
                                                                <p className="text-xs text-gray-500">
                                                                    ZIP up to 20MB
                                                                </p>
                                                            </div>
                                                        </div>
                                                    ) : (
                                                        <div className="mt-1 flex items-center justify-between px-6 py-4 border-2 border-indigo-300 border-dashed rounded-md bg-indigo-50">
                                                            <div className="flex items-center">
                                                                <svg className="h-8 w-8 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                                <div>
                                                                    <p className="text-sm font-medium text-indigo-700 truncate max-w-xs">
                                                                        {data.file.name}
                                                                    </p>
                                                                    <p className="text-xs text-indigo-500">
                                                                        {(data.file.size / 1024 / 1024).toFixed(2)} MB
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <button
                                                                type="button"
                                                                onClick={() => setData('file', null)}
                                                                className="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition-colors"
                                                                title="Remove file"
                                                            >
                                                                <svg className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    )}
                                                    {errors.file && (
                                                        <p className="mt-2 text-sm text-red-600">
                                                            {errors.file}
                                                        </p>
                                                    )}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button
                                        type="submit"
                                        className="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm"
                                        disabled={processing}
                                    >
                                        {processing ? 'Uploading...' : 'Submit Solution'}
                                    </button>
                                    <button
                                        type="button"
                                        className="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                        onClick={() => {
                                            setShowSubmissionModal(false);
                                            reset();
                                        }}
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

export default MyProjectIndex;
