import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import RoadmapGraph from './Partials/RoadmapGraph';

const ProjectShow = ({ auth, project, userSkills = [] }) => {
    const [expandedTask, setExpandedTask] = useState(null);
    const [warningModal, setWarningModal] = useState({ isOpen: false, task: null, missingSkills: [] });
    const [viewMode, setViewMode] = useState('graph'); // 'graph' or 'list'

    // Check if task is completed by the user
    const isTaskCompleted = (taskId) => {
        const task = project.tasks.find(t => t.id === taskId);
        return task?.user_tasks?.some(ut => ut.status === 'completed');
    };

    // Check if task is locked due to prerequisites (DAG Logic)
    const isDAGLocked = (task) => {
        if (!task.prerequisites || task.prerequisites.length === 0) return false;
        // Check if ALL prerequisites are completed
        const allPrereqsCompleted = task.prerequisites.every(prereq => isTaskCompleted(prereq.id));
        return !allPrereqsCompleted;
    };

    // Check if task has missing skills (Advisory Lock)
    const isSkillLocked = (task) => {
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

    const handleTaskClick = (task) => {
        const dagLocked = isDAGLocked(task);

        if (dagLocked) {
            // Optional: Show a message that it's locked by dependencies
            return;
        }

        const skillLocked = isSkillLocked(task);
        if (skillLocked && expandedTask !== task.id) {
            const missing = getMissingSkills(task);
            setWarningModal({ isOpen: true, task: task, missingSkills: missing });
        }
        toggleTask(task.id);
    };

    const closeWarningModal = () => {
        setWarningModal({ ...warningModal, isOpen: false });
    };

    return (
        <div className="min-h-screen bg-gray-50">
            <Head title={project.title} />

            {/* Warning Modal */}
            {warningModal.isOpen && (
                <div className="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div className="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div className="fixed inset-0 transition-opacity" aria-hidden="true" onClick={closeWarningModal}></div>
                        <span className="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div className="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div className="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div className="sm:flex sm:items-start">
                                    <div className="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <svg className="h-6 w-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <div className="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 className="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                            Skill Gap Detected
                                        </h3>
                                        <div className="mt-2">
                                            <p className="text-sm text-gray-500">
                                                You are attempting <strong>{warningModal.task?.title}</strong>, but you are missing some recommended skills.
                                            </p>
                                            <div className="mt-4 bg-yellow-50 p-3 rounded-md border border-yellow-100">
                                                <h4 className="text-xs font-semibold text-yellow-800 uppercase tracking-wider mb-2">Missing Skills</h4>
                                                <div className="flex flex-wrap gap-2">
                                                    {warningModal.missingSkills.map(skill => (
                                                        <span key={skill.id} className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white text-yellow-800 border border-yellow-200">
                                                            {skill.name}
                                                        </span>
                                                    ))}
                                                </div>
                                            </div>
                                            <p className="mt-4 text-sm text-gray-500">
                                                Proceeding without these skills might be challenging. We recommend reviewing these topics, but you are free to learn by doing!
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button
                                    type="button"
                                    className="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm"
                                    onClick={closeWarningModal}
                                >
                                    I Understand, Proceed
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            )}

            <nav className="bg-white border-b border-gray-200">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-16">
                        <div className="flex items-center">
                            <Link href="/projects" className="flex items-center text-gray-500 hover:text-gray-700">
                                <svg className="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to Library
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
                                    <dt className="text-sm font-medium text-gray-500">Recommended Tech Stack</dt>
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
                                    <div className="flex justify-between items-center mb-4">
                                        <dt className="text-sm font-medium text-gray-500">Project Roadmap</dt>
                                        <div className="flex space-x-2 bg-gray-100 p-1 rounded-lg">
                                            <button
                                                onClick={() => setViewMode('graph')}
                                                className={`px-3 py-1 text-xs font-medium rounded-md transition-colors ${
                                                    viewMode === 'graph'
                                                        ? 'bg-white text-gray-900 shadow'
                                                        : 'text-gray-500 hover:text-gray-700'
                                                }`}
                                            >
                                                Graph View
                                            </button>
                                            <button
                                                onClick={() => setViewMode('list')}
                                                className={`px-3 py-1 text-xs font-medium rounded-md transition-colors ${
                                                    viewMode === 'list'
                                                        ? 'bg-white text-gray-900 shadow'
                                                        : 'text-gray-500 hover:text-gray-700'
                                                }`}
                                            >
                                                List View
                                            </button>
                                        </div>
                                    </div>
                                    <dd className="mt-1 text-sm text-gray-900">
                                        {viewMode === 'graph' ? (
                                            <RoadmapGraph
                                                projectTitle={project.title}
                                                tasks={project.tasks}
                                                userTasks={project.tasks.flatMap(t => t.user_tasks || [])}
                                                userSkills={userSkills}
                                                onTaskClick={(task) => {
                                                    handleTaskClick(task);
                                                    setViewMode('list'); // Switch to list to show details
                                                }}
                                            />
                                        ) : (
                                            <div className="space-y-8">
                                                {Object.entries(project.tasks.reduce((acc, task) => {
                                                    const cat = task.category || 'Other';
                                                    if (!acc[cat]) acc[cat] = [];
                                                    acc[cat].push(task);
                                                    return acc;
                                                }, {})).map(([category, tasks]) => (
                                                    <div key={category} className="border border-gray-200 rounded-md overflow-hidden">
                                                        <div className="bg-gray-100 px-6 py-3 border-b border-gray-200">
                                                            <h4 className="text-sm font-bold text-gray-700 uppercase tracking-wider">{category}</h4>
                                                        </div>
                                                        <table className="min-w-full divide-y divide-gray-200">
                                                            <thead className="bg-gray-50">
                                                                <tr>
                                                                    <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">
                                                                        Task
                                                                    </th>
                                                                    <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">
                                                                        Dependencies
                                                                    </th>
                                                                    <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">
                                                                        Recommended Skills
                                                                    </th>
                                                                    <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">
                                                                        Status
                                                                    </th>
                                                                    <th scope="col" className="relative px-6 py-3">
                                                                        <span className="sr-only">Details</span>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody className="bg-white divide-y divide-gray-200">
                                                                {tasks.map((task, index) => {
                                                                    const completed = isTaskCompleted(task.id);
                                                                    const dagLocked = isDAGLocked(task);
                                                                    const skillLocked = isSkillLocked(task);
                                                                    const missingSkills = skillLocked ? getMissingSkills(task) : [];
                                                                    const isExpanded = expandedTask === task.id;

                                                                    let rowClass = "hover:bg-gray-50 cursor-pointer transition-colors duration-150";
                                                                    if (dagLocked) {
                                                                        rowClass = "bg-gray-100 cursor-not-allowed opacity-75";
                                                                    } else if (completed) {
                                                                        rowClass = "bg-green-50 hover:bg-green-100 cursor-pointer";
                                                                    } else if (isExpanded) {
                                                                        rowClass = "bg-blue-50 hover:bg-blue-100 cursor-pointer";
                                                                    }

                                                                    return (
                                                                        <React.Fragment key={task.id}>
                                                                            <tr className={rowClass} onClick={() => handleTaskClick(task)}>
                                                                                <td className="px-6 py-4 whitespace-nowrap">
                                                                                    <div className="flex items-center">
                                                                                        <div className={`shrink-0 h-8 w-8 flex items-center justify-center rounded-full font-bold text-xs ${
                                                                                            completed ? 'bg-green-200 text-green-800' :
                                                                                            dagLocked ? 'bg-gray-200 text-gray-500' :
                                                                                            'bg-blue-100 text-blue-600'
                                                                                        }`}>
                                                                                            {completed ? (
                                                                                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7"></path></svg>
                                                                                            ) : dagLocked ? (
                                                                                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                                                            ) : (
                                                                                                tasks.indexOf(task) + 1
                                                                                            )}
                                                                                        </div>
                                                                                        <div className="ml-3">
                                                                                            <div className={`text-sm font-medium ${dagLocked ? 'text-gray-500' : 'text-gray-900'}`}>{task.title}</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td className="px-6 py-4">
                                                                                    {task.prerequisites && task.prerequisites.length > 0 ? (
                                                                                        <div className="flex flex-col space-y-1">
                                                                                            {task.prerequisites.map(p => (
                                                                                                <span key={p.id} className="text-xs text-gray-500 flex items-center">
                                                                                                    <span className="text-gray-400 mr-1">↳</span>
                                                                                                    {p.title}
                                                                                                </span>
                                                                                            ))}
                                                                                        </div>
                                                                                    ) : (
                                                                                        <span className="text-gray-400 text-xs">-</span>
                                                                                    )}
                                                                                </td>
                                                                                <td className="px-6 py-4">
                                                                                    <div className="text-sm text-gray-900">
                                                                                        {task.skills && task.skills.length > 0 ? (
                                                                                            <span className="text-gray-600">
                                                                                                {task.skills.map(s => s.name).join(', ')}
                                                                                            </span>
                                                                                        ) : (
                                                                                            <span className="text-gray-400 italic">None specified</span>
                                                                                        )}
                                                                                    </div>
                                                                                    {skillLocked && !dagLocked && (
                                                                                        <div className="text-xs text-red-500 mt-1">
                                                                                            Missing: {missingSkills.map(s => s.name).join(', ')}
                                                                                        </div>
                                                                                    )}
                                                                                </td>
                                                                                <td className="px-6 py-4 whitespace-nowrap">
                                                                                    {dagLocked ? (
                                                                                        <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Locked</span>
                                                                                    ) : completed ? (
                                                                                        <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Completed</span>
                                                                                    ) : skillLocked ? (
                                                                                        <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Skill Gap</span>
                                                                                    ) : (
                                                                                        <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Active</span>
                                                                                    )}
                                                                                </td>
                                                                                <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                                                    {!dagLocked && (
                                                                                        <span className="text-indigo-600 hover:text-indigo-900">
                                                                                            {isExpanded ? 'Hide' : 'Details'}
                                                                                        </span>
                                                                                    )}
                                                                                </td>
                                                                            </tr>
                                                                            {isExpanded && !dagLocked && (
                                                                                <tr>
                                                                                    <td colSpan="5" className="px-6 py-4 bg-gray-50 border-t border-gray-100">
                                                                                        <div className="text-sm text-gray-700 space-y-4">
                                                                                            <div>
                                                                                                <h4 className="font-semibold text-gray-900">Description</h4>
                                                                                                {task.scenario && <p className="mb-3 italic text-gray-600">{task.scenario}</p>}
                                                                                                <p className="mt-1">{task.description}</p>
                                                                                            </div>
                                                                                            <div>
                                                                                                <h4 className="font-semibold text-gray-900">Expected Outcome</h4>
                                                                                                <p className="mt-1">{task.expected_outcome || "No specific outcome defined yet."}</p>
                                                                                            </div>
                                                                                            {skillLocked && (
                                                                                                <div className="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-2">
                                                                                                    <div className="flex">
                                                                                                        <div className="shrink-0">
                                                                                                            <svg className="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                                                                                <path fillRule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clipRule="evenodd" />
                                                                                                            </svg>
                                                                                                        </div>
                                                                                                        <div className="ml-3">
                                                                                                            <p className="text-sm text-yellow-700">
                                                                                                                Missing recommended skills. You may use any tech stack to achieve the expected outcome.
                                                                                                            </p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            )}
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            )}
                                                                        </React.Fragment>
                                                                    );
                                                                })}
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                ))}
                                            </div>
                                        )}
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
