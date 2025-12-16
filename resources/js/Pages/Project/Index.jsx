import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';

const difficultyOrder = { beginner: 1, intermediate: 2, advanced: 3 };

const ProjectIndex = ({ auth, projects, userSkills = [] }) => {
    const [filter, setFilter] = useState('all');

    const getMatchPercentage = (project) => {
        const totalSkills = project?.skills?.length || 0;
        if (totalSkills === 0) return 100;
        const matchingSkills = project.skills.filter((skill) => userSkills.includes(skill.id)).length;
        return Math.round((matchingSkills / totalSkills) * 100);
    };

    const sortProjects = (list) => {
        return [...list].sort((a, b) => {
            const matchA = getMatchPercentage(a);
            const matchB = getMatchPercentage(b);
            if (matchA !== matchB) return matchB - matchA;

            const diffA = difficultyOrder[a.difficulty_level] || 0;
            const diffB = difficultyOrder[b.difficulty_level] || 0;
            if (diffA !== diffB) return diffB - diffA;

            const tasksA = a.tasks?.length || 0;
            const tasksB = b.tasks?.length || 0;
            return tasksB - tasksA;
        });
    };

    const renderProjectCard = (project) => {
        const matchPercentage = getMatchPercentage(project);

        return (
            <div key={project.id} className="bg-white border border-gray-100 shadow-sm rounded-xl hover:shadow-md transition-shadow flex flex-col h-full">
                <div className="px-5 py-5 flex-1 space-y-4">
                    <div className="flex items-start justify-between gap-3">
                        <div className="flex items-center gap-2">
                            <span
                                className={`inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold capitalize ${
                                    project.difficulty_level === 'beginner'
                                        ? 'bg-green-100 text-green-800'
                                        : project.difficulty_level === 'intermediate'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : 'bg-red-100 text-red-800'
                                }`}
                            >
                                {project.difficulty_level}
                            </span>
                            <span className="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                {matchPercentage}% match
                            </span>
                            {matchPercentage === 100 && (
                                <span className="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    Perfect fit
                                </span>
                            )}
                        </div>
                        <span className="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-700 border border-gray-200">
                            {project.tasks?.length || 0} tasks
                        </span>
                    </div>

                    <div className="space-y-1">
                        <h3 className="text-lg font-semibold text-gray-900 leading-tight line-clamp-1">{project.title}</h3>
                        <p className="text-sm text-gray-600 leading-relaxed line-clamp-3">{project.description}</p>
                    </div>

                    <div className="border border-gray-100 rounded-lg p-3 bg-gray-50/60">
                        <div className="flex items-center justify-between mb-2">
                            <h4 className="text-xs font-semibold text-gray-600 uppercase tracking-wide">Core skills</h4>
                            <span className="text-[11px] text-gray-500">{project.skills.length} listed</span>
                        </div>
                        <div className="flex flex-wrap gap-2">
                            {project.skills.slice(0, 5).map((skill) => (
                                <span
                                    key={skill.id}
                                    className={`inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border leading-none ${
                                        userSkills.includes(skill.id)
                                            ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                            : 'bg-white text-gray-600 border-gray-200'
                                    }`}
                                >
                                    {skill.name}
                                </span>
                            ))}
                            {project.skills.length > 5 ? (
                                <span className="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-white text-gray-500 border border-gray-200">
                                    +{project.skills.length - 5}
                                </span>
                            ) : null}
                        </div>
                    </div>

                    <div className="flex items-center gap-3 text-xs text-gray-500">
                        <div className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-gray-50 border border-gray-200">
                            <span className="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                            <span>{matchPercentage}% overlap with your skills</span>
                        </div>
                        <div className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-gray-50 border border-gray-200">
                            <span className="text-gray-400">📋</span>
                            <span>{project.tasks?.length || 0} tasks in track</span>
                        </div>
                    </div>
                </div>

                <div className="bg-gray-50 px-5 py-4 border-t border-gray-100">
                    <Link
                        href={`/project/${project.id}`}
                        className="w-full inline-flex justify-center items-center gap-2 py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                    >
                        View Project
                    </Link>
                </div>
            </div>
        );
    };

    const filteredProjects = projects.filter((project) => {
        if (filter !== 'all' && filter !== 'recommended' && project.difficulty_level !== filter) return false;

        const matchPct = getMatchPercentage(project);
        if (filter === 'recommended' && matchPct <= 0) return false;

        return true;
    });

    const sortedProjects = sortProjects(filteredProjects);
    const recommendedProjects = filter === 'all' ? sortedProjects.filter((project) => getMatchPercentage(project) === 100) : [];
    const otherProjects = filter === 'all' ? sortedProjects.filter((project) => getMatchPercentage(project) !== 100) : sortedProjects;

    return (
        <div className="min-h-screen bg-gray-50">
            <Head title="Project Library" />

            <nav className="bg-white border-b border-gray-200">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="h-16 flex items-center justify-between">
                        <div className="flex items-center">
                            <Link href="/dashboard" className="flex items-center text-gray-500 hover:text-gray-700">
                                <svg className="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to Dashboard
                            </Link>
                        </div>
                        <div className="flex items-center">
                            <h1 className="text-xl font-bold text-gray-900">Project Library</h1>
                        </div>
                        <div className="text-sm text-gray-500">{projects.length} projects</div>
                    </div>
                </div>
            </nav>

            <main className="py-10">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex flex-col gap-4 mb-8">
                        <div className="bg-white p-1 rounded-lg shadow-sm border border-gray-200 inline-flex flex-wrap justify-center">
                            <button
                                onClick={() => setFilter('all')}
                                className={`px-4 py-2 text-sm font-medium rounded-md transition-colors ${
                                    filter === 'all' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700'
                                }`}
                            >
                                All Projects
                            </button>
                            <button
                                onClick={() => setFilter('recommended')}
                                className={`px-4 py-2 text-sm font-medium rounded-md transition-colors ${
                                    filter === 'recommended' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700'
                                }`}
                            >
                                Recommended
                            </button>
                            <button
                                onClick={() => setFilter('beginner')}
                                className={`px-4 py-2 text-sm font-medium rounded-md transition-colors ${
                                    filter === 'beginner' ? 'bg-green-100 text-green-700' : 'text-gray-500 hover:text-gray-700'
                                }`}
                            >
                                Beginner
                            </button>
                            <button
                                onClick={() => setFilter('intermediate')}
                                className={`px-4 py-2 text-sm font-medium rounded-md transition-colors ${
                                    filter === 'intermediate' ? 'bg-yellow-100 text-yellow-700' : 'text-gray-500 hover:text-gray-700'
                                }`}
                            >
                                Intermediate
                            </button>
                            <button
                                onClick={() => setFilter('advanced')}
                                className={`px-4 py-2 text-sm font-medium rounded-md transition-colors ${
                                    filter === 'advanced' ? 'bg-red-100 text-red-700' : 'text-gray-500 hover:text-gray-700'
                                }`}
                            >
                                Advanced
                            </button>
                        </div>
                    </div>

                    {filter === 'all' && recommendedProjects.length > 0 && (
                        <div className="mb-12">
                            <h2 className="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <span className="bg-indigo-100 text-indigo-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Recommended</span>
                                Perfect Matches for You
                            </h2>
                            <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                                {recommendedProjects.map((project) => renderProjectCard(project))}
                            </div>
                        </div>
                    )}

                    {filter === 'all' && recommendedProjects.length > 0 && (
                        <h2 className="text-xl font-bold text-gray-900 mb-6">All Projects</h2>
                    )}

                    <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        {otherProjects.map((project) => renderProjectCard(project))}
                    </div>
                </div>
            </main>
        </div>
    );
};

export default ProjectIndex;
