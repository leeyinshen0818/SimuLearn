import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';

const ProjectShow = ({ auth, project, userSkills = [] }) => {
    const [expandedTask, setExpandedTask] = useState(null);

    const isTaskLocked = (task) => {
        if (!task.skills || task.skills.length === 0) return false;
        return !task.skills.every(skill => userSkills.includes(skill.id));
    };

    const getMissingSkills = (task) => {
        if (!task.skills) return [];
        return task.skills.filter(skill => !userSkills.includes(skill.id));
    };

    const toggleTask = (taskId) => {
        if (expandedTask === taskId) {
            setExpandedTask(null);
        } else {
            setExpandedTask(taskId);
        }
    };

    return (
        <div className="min-h-screen bg-gray-50">
            <Head title={project.title} />

            {/* Navigation (Simplified for now) */}
            <nav className="bg-white border-b border-gray-200">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-16">
                        <div className="flex items-center">
                            <Link href="/dashboard" className="flex items-center text-gray-500 hover:text-gray-700">
                                <svg className="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to Dashboard
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            <main className="py-10">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div className="px-4 py-5 sm:px-6">
                            <h3 className="text-lg leading-6 font-medium text-gray-900">
                                {project.title}
                            </h3>
                            <p className="mt-1 max-w-2xl text-sm text-gray-500">
                                {project.description}
                            </p>
                        </div>
                        <div className="border-t border-gray-200 px-4 py-5 sm:px-6">
                            <dl className="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                                <div className="sm:col-span-1">
                                    <dt className="text-sm font-medium text-gray-500">Difficulty</dt>
                                    <dd className="mt-1 text-sm text-gray-900 capitalize">{project.difficulty_level}</dd>
                                </div>
                                <div className="sm:col-span-1">
                                    <dt className="text-sm font-medium text-gray-500">Tasks</dt>
                                    <dd className="mt-1 text-sm text-gray-900">{project.tasks.length} Tasks</dd>
                                </div>
                                <div className="sm:col-span-2">
                                    <dt className="text-sm font-medium text-gray-500">Skills Required</dt>
                                    <dd className="mt-1 text-sm text-gray-900">
                                        <div className="flex flex-wrap gap-2">
                                            {project.skills.map(skill => (
                                                <span key={skill.id} className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {skill.name}
                                                </span>
                                            ))}
                                        </div>
                                    </dd>
                                </div>
                                <div className="sm:col-span-2">
                                    <dt className="text-sm font-medium text-gray-500">Project Roadmap</dt>
                                    <dd className="mt-1 text-sm text-gray-900">
                                        <ul className="border border-gray-200 rounded-md divide-y divide-gray-200">
                                            {project.tasks.map((task) => {
                                                const locked = isTaskLocked(task);
                                                const missingSkills = locked ? getMissingSkills(task) : [];
                                                const isExpanded = expandedTask === task.id;

                                                return (
                                                    <li key={task.id} className={`pl-3 pr-4 py-4 flex flex-col text-sm ${locked ? 'bg-gray-50 opacity-75' : 'hover:bg-gray-50 cursor-pointer'}`} onClick={() => !locked && toggleTask(task.id)}>
                                                        <div className="flex items-start justify-between w-full">
                                                            <div className="w-0 flex-1 flex items-start">
                                                                <div className="mt-1 mr-3 shrink-0">
                                                                    {locked ? (
                                                                        <svg className="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                                        </svg>
                                                                    ) : (
                                                                        <svg className={`w-5 h-5 text-green-500 transition-transform ${isExpanded ? 'transform rotate-90' : ''}`} fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                        </svg>
                                                                    )}
                                                                </div>
                                                                <div className="flex flex-col flex-1">
                                                                    <span className={`text-base font-medium ${locked ? 'text-gray-500' : 'text-gray-900'}`}>
                                                                        {task.title}
                                                                    </span>
                                                                    <p className={`mt-1 text-sm ${locked ? 'text-gray-400' : 'text-gray-500'}`}>
                                                                        {task.description}
                                                                    </p>

                                                                    {/* Skills Display */}
                                                                    <div className="mt-2 flex flex-wrap gap-2">
                                                                        {task.skills && task.skills.map(skill => {
                                                                            const hasSkill = userSkills.includes(skill.id);
                                                                            return (
                                                                                <span
                                                                                    key={skill.id}
                                                                                    className={`inline-flex items-center px-2 py-0.5 rounded text-xs font-medium border
                                                                                        ${locked
                                                                                            ? (hasSkill ? 'bg-gray-100 text-gray-500 border-gray-200' : 'bg-red-50 text-red-600 border-red-200')
                                                                                            : 'bg-green-50 text-green-700 border-green-200'
                                                                                        }`}
                                                                                >
                                                                                    {skill.name}
                                                                                    {!hasSkill && locked && (
                                                                                        <svg className="ml-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                                                            <path fillRule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clipRule="evenodd" />
                                                                                        </svg>
                                                                                    )}
                                                                                    {hasSkill && (
                                                                                        <svg className="ml-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                                                            <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                                                                        </svg>
                                                                                    )}
                                                                                </span>
                                                                            );
                                                                        })}
                                                                    </div>

                                                                    {locked && (
                                                                        <div className="mt-2 flex items-center text-xs text-red-500 font-medium">
                                                                            <svg className="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                                <path fillRule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clipRule="evenodd" />
                                                                            </svg>
                                                                            Task Locked: Missing required skills.
                                                                        </div>
                                                                    )}
                                                                </div>
                                                            </div>
                                                            <div className="ml-4 shrink-0 self-start mt-1">
                                                                <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${locked ? 'bg-gray-100 text-gray-500' : 'bg-indigo-100 text-indigo-800'}`}>
                                                                    {task.category}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        {/* Expanded Details */}
                                                        {isExpanded && !locked && (
                                                            <div className="mt-4 ml-8 p-4 bg-indigo-50 rounded-md border border-indigo-100">
                                                                <h4 className="text-sm font-semibold text-indigo-900 mb-2">Expected Outcome</h4>
                                                                <p className="text-sm text-indigo-800">
                                                                    {task.expected_outcome || "No specific outcome defined yet."}
                                                                </p>
                                                                <div className="mt-3 pt-3 border-t border-indigo-200">
                                                                    <p className="text-xs text-indigo-600">
                                                                        <span className="font-semibold">Recommended Stack:</span> {task.skills.map(s => s.name).join(', ')}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        )}
                                                    </li>
                                                );
                                            })}
                                        </ul>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                        <div className="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end">
                            <button className="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Start Simulation
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    );
};

export default ProjectShow;
