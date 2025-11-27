import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';

const ProjectIndex = ({ auth, projects, userSkills = [] }) => {
    const [filter, setFilter] = useState('all'); // 'all', 'recommended', 'beginner', 'intermediate', 'advanced'

    // Helper to calculate match percentage
    const getMatchPercentage = (project) => {
        const totalSkills = project.skills ? project.skills.length : 0;
        if (totalSkills === 0) return 100;
        const matchingSkills = project.skills.filter(s => userSkills.includes(s.id)).length;
        return Math.round((matchingSkills / totalSkills) * 100);
    };

    let filteredProjects = projects.filter(project => {
        if (filter === 'all') return true;
        if (filter === 'recommended') {
            // Show projects with at least some match
            return getMatchPercentage(project) > 0;
        }
        return project.difficulty_level === filter;
    });

    // Sorting Logic
    filteredProjects.sort((a, b) => {
        if (filter === 'all') {
            // Sort by difficulty: Beginner -> Intermediate -> Advanced
            const difficultyOrder = { 'beginner': 1, 'intermediate': 2, 'advanced': 3 };
            const diffA = difficultyOrder[a.difficulty_level] || 4;
            const diffB = difficultyOrder[b.difficulty_level] || 4;
            return diffA - diffB;
        }
        if (filter === 'recommended') {
            // Sort by match percentage: High -> Low
            return getMatchPercentage(b) - getMatchPercentage(a);
        }
        return 0;
    });

    // Split projects for 'all' view to highlight perfect matches
    const recommendedProjects = filter === 'all'
        ? filteredProjects.filter(p => getMatchPercentage(p) === 100)
        : [];

    const otherProjects = filter === 'all'
        ? filteredProjects.filter(p => getMatchPercentage(p) !== 100)
        : filteredProjects;

    const renderProjectCard = (project) => {
        const matchPercentage = getMatchPercentage(project);

        return (
            <div key={project.id} className="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow flex flex-col h-full">
                <div className="px-4 py-5 sm:p-6 flex-1">
                    <div className="flex justify-between items-start mb-4">
                        <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                            ${project.difficulty_level === 'beginner' ? 'bg-green-100 text-green-800' :
                              project.difficulty_level === 'intermediate' ? 'bg-yellow-100 text-yellow-800' :
                              'bg-red-100 text-red-800'}`}>
                            {project.difficulty_level}
                        </span>
                        {matchPercentage === 100 && (
                            <span className="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                Perfect Match
                            </span>
                        )}
                    </div>

                    <h3 className="text-lg font-medium text-gray-900 truncate mb-2">
                        {project.title}
                    </h3>
                    <p className="text-sm text-gray-500 line-clamp-3 mb-4">
                        {project.description}
                    </p>

                    <div className="mt-4">
                        <h4 className="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Skills</h4>
                        <div className="flex flex-wrap gap-2">
                            {project.skills.slice(0, 4).map(skill => (
                                <span
                                    key={skill.id}
                                    className={`inline-flex items-center px-2 py-0.5 rounded text-xs font-medium border
                                        ${userSkills.includes(skill.id)
                                            ? 'bg-green-50 text-green-700 border-green-200'
                                            : 'bg-gray-50 text-gray-500 border-gray-200'}`}
                                >
                                    {skill.name}
                                </span>
                            ))}
                            {project.skills.length > 4 && (
                                <span className="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-50 text-gray-500 border border-gray-200">
                                    +{project.skills.length - 4}
                                </span>
                            )}
                        </div>
                    </div>
                </div>
                <div className="bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
                    <Link
                        href={`/project/${project.id}`}
                        className="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        View Project
                    </Link>
                </div>
            </div>
        );
    };

    return (
        <div className="min-h-screen bg-gray-50">
            <Head title="All Projects" />

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
                        <div className="flex items-center">
                            <h1 className="text-xl font-bold text-gray-900">Project Library</h1>
                        </div>
                    </div>
                </div>
            </nav>

            <main className="py-10">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    {/* Filters */}
                    <div className="flex justify-center mb-8 flex-wrap gap-2">
                        <div className="bg-white p-1 rounded-lg shadow-sm border border-gray-200 inline-flex flex-wrap justify-center">
                            <button
                                onClick={() => setFilter('all')}
                                className={`px-4 py-2 text-sm font-medium rounded-md transition-colors ${
                                    filter === 'all'
                                    ? 'bg-indigo-100 text-indigo-700'
                                    : 'text-gray-500 hover:text-gray-700'
                                }`}
                            >
                                All Projects
                            </button>
                            <button
                                onClick={() => setFilter('recommended')}
                                className={`px-4 py-2 text-sm font-medium rounded-md transition-colors ${
                                    filter === 'recommended'
                                    ? 'bg-indigo-100 text-indigo-700'
                                    : 'text-gray-500 hover:text-gray-700'
                                }`}
                            >
                                Recommended
                            </button>
                            <button
                                onClick={() => setFilter('beginner')}
                                className={`px-4 py-2 text-sm font-medium rounded-md transition-colors ${
                                    filter === 'beginner'
                                    ? 'bg-green-100 text-green-700'
                                    : 'text-gray-500 hover:text-gray-700'
                                }`}
                            >
                                Beginner
                            </button>
                            <button
                                onClick={() => setFilter('intermediate')}
                                className={`px-4 py-2 text-sm font-medium rounded-md transition-colors ${
                                    filter === 'intermediate'
                                    ? 'bg-yellow-100 text-yellow-700'
                                    : 'text-gray-500 hover:text-gray-700'
                                }`}
                            >
                                Intermediate
                            </button>
                            <button
                                onClick={() => setFilter('advanced')}
                                className={`px-4 py-2 text-sm font-medium rounded-md transition-colors ${
                                    filter === 'advanced'
                                    ? 'bg-red-100 text-red-700'
                                    : 'text-gray-500 hover:text-gray-700'
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
                                {recommendedProjects.map(project => renderProjectCard(project))}
                            </div>
                        </div>
                    )}

                    {filter === 'all' && recommendedProjects.length > 0 && (
                        <h2 className="text-xl font-bold text-gray-900 mb-6">All Projects</h2>
                    )}

                    <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        {otherProjects.map(project => renderProjectCard(project))}
                    </div>
                </div>
            </main>
        </div>
    );
};

export default ProjectIndex;
