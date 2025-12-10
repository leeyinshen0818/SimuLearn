import React from 'react';
import { Head, Link } from '@inertiajs/react';

const mockInsights = {
    readiness: 72,
    summary:
        'Based on recent submissions and completed tasks, you show strong backend proficiency and growing frontend confidence. Focus next on API robustness and UI polish to reach a production-ready level.',
    strengths: [
        'Laravel + REST fundamentals (clean controllers, auth flow)',
        'Database modeling and migrations',
        'Basic React component patterns and state handling',
    ],
    gaps: [
        'Integration testing coverage (API + UI)',
        'Error states and resilience for client-side flows',
        'UI accessibility and micro-interactions',
    ],
    recommendedRoles: [
        'Junior Full Stack Developer',
        'Backend-Focused Web Engineer',
        'API & Integrations Developer',
    ],
    nextSteps: [
        'Add integration tests for two recent tasks (auth + submissions).',
        'Implement optimistic UI updates and graceful fallback states.',
        'Refine one UI flow with accessibility checks (aria labels, focus states).',
    ],
    learningTracks: [
        {
            title: 'API Quality & Resilience',
            items: ['Request validation hardening', 'Integration tests', 'Background jobs + retries'],
            duration: '1-2 weeks',
        },
        {
            title: 'Frontend Polish',
            items: ['Accessible components', 'Loading/skeleton patterns', 'Error boundaries'],
            duration: '1 week',
        },
        {
            title: 'DevOps Basics',
            items: ['Environment config hygiene', 'Logging/monitoring basics', 'Deploy checklist'],
            duration: '1 week',
        },
    ],
};

export default function CareerPath({ auth }) {
    const user = auth?.user || {};

    return (
        <div className="flex h-screen bg-gray-50">
            <Head title="Career Path" />

            {/* Sidebar */}
            <div className="w-64 bg-white border-r border-gray-200 flex flex-col shrink-0">
                <div className="h-16 flex items-center px-6 border-b border-gray-200">
                    <Link href="/" className="flex items-center gap-2">
                        <div className="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                            <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span className="text-xl font-bold text-gray-900">SimuLearn</span>
                    </Link>
                </div>

                <nav className="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <Link href="/dashboard" className="flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 group transition-colors">
                        <svg className="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </Link>
                    <Link href="/my-projects" className="flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 group transition-colors">
                        <svg className="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        My Projects
                    </Link>
                    <Link href="/profile/skills" className="flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 group transition-colors">
                        <svg className="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Skill Profile
                    </Link>
                    <Link href="/career-path" className="flex items-center px-4 py-3 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg group">
                        <svg className="w-5 h-5 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Career Path
                    </Link>
                </nav>

                <div className="p-4 border-t border-gray-200">
                    <div className="flex items-center gap-3 mb-4 px-2">
                        <div className="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                            {user.name ? user.name.charAt(0) : 'U'}
                        </div>
                        <div className="flex-1 min-w-0">
                            <p className="text-sm font-medium text-gray-900 truncate">{user.name || 'User'}</p>
                            <p className="text-xs text-gray-500 truncate">{user.email || 'email@example.com'}</p>
                        </div>
                    </div>
                    <Link
                        href="/logout"
                        method="post"
                        as="button"
                        className="w-full flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Log Out
                    </Link>
                </div>
            </div>

            {/* Main Content */}
            <div className="flex-1 flex flex-col overflow-hidden">
                <header className="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8 shrink-0">
                    <h1 className="text-2xl font-bold text-gray-900">Career Path</h1>
                    <div className="flex items-center gap-4 text-sm text-gray-500">
                        <span className="px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">Mock Mode</span>
                    </div>
                </header>

                <main className="flex-1 overflow-y-auto px-6 py-8 bg-gray-50">
                    <div className="max-w-6xl mx-auto space-y-6">
                        <div className="bg-white border border-indigo-100 shadow-sm rounded-xl p-6">
                            <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <p className="text-xs uppercase tracking-[0.15em] text-indigo-500 font-bold">AI insights paused</p>
                                    <h1 className="text-2xl font-bold text-slate-900 mt-1">Personalized Career Path</h1>
                                    <p className="text-sm text-slate-600 mt-1 max-w-2xl">
                                        Live AI insights are temporarily offline. This mock view shows the type of guidance you will receive once AI is re-enabled.
                                    </p>
                                </div>
                                <div className="bg-indigo-50 border border-indigo-100 rounded-lg px-4 py-3 text-center shadow-inner">
                                    <p className="text-xs font-semibold text-indigo-600">Readiness Score</p>
                                    <p className="text-3xl font-bold text-indigo-700">{mockInsights.readiness}%</p>
                                    <p className="text-[11px] text-indigo-500 mt-1">Mock value</p>
                                </div>
                            </div>
                        </div>

                        <div className="grid gap-6 md:grid-cols-3">
                            <div className="md:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
                                <h2 className="text-lg font-semibold text-slate-900">Summary</h2>
                                <p className="text-slate-700 leading-relaxed">{mockInsights.summary}</p>
                                <div className="grid sm:grid-cols-2 gap-4">
                                    <div className="bg-indigo-50 border border-indigo-100 rounded-lg p-4">
                                        <h3 className="text-sm font-semibold text-indigo-800">Strengths</h3>
                                        <ul className="mt-2 space-y-1 text-sm text-indigo-900">
                                            {mockInsights.strengths.map((item) => (
                                                <li key={item} className="flex gap-2">
                                                    <span className="text-indigo-500">•</span>
                                                    <span>{item}</span>
                                                </li>
                                            ))}
                                        </ul>
                                    </div>
                                    <div className="bg-amber-50 border border-amber-100 rounded-lg p-4">
                                        <h3 className="text-sm font-semibold text-amber-800">Focus Areas</h3>
                                        <ul className="mt-2 space-y-1 text-sm text-amber-900">
                                            {mockInsights.gaps.map((item) => (
                                                <li key={item} className="flex gap-2">
                                                    <span className="text-amber-500">•</span>
                                                    <span>{item}</span>
                                                </li>
                                            ))}
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div className="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
                                <h2 className="text-lg font-semibold text-slate-900">Recommended Roles</h2>
                                <div className="space-y-2">
                                    {mockInsights.recommendedRoles.map((role) => (
                                        <div key={role} className="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-800 bg-slate-50">
                                            {role}
                                        </div>
                                    ))}
                                </div>
                                <div className="pt-2">
                                    <p className="text-xs text-slate-500">Generated content is mocked until AI is enabled.</p>
                                </div>
                            </div>
                        </div>

                        <div className="grid gap-6 md:grid-cols-3">
                            <div className="md:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
                                <h2 className="text-lg font-semibold text-slate-900">Next Steps</h2>
                                <ol className="list-decimal list-inside space-y-2 text-slate-800 text-sm">
                                    {mockInsights.nextSteps.map((step) => (
                                        <li key={step}>{step}</li>
                                    ))}
                                </ol>
                            </div>
                            <div className="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
                                <h2 className="text-lg font-semibold text-slate-900">Learning Tracks</h2>
                                <div className="space-y-3">
                                    {mockInsights.learningTracks.map((track) => (
                                        <div key={track.title} className="border border-slate-200 rounded-lg p-3 bg-slate-50">
                                            <div className="flex items-center justify-between text-sm font-semibold text-slate-900">
                                                <span>{track.title}</span>
                                                <span className="text-xs text-slate-500">{track.duration}</span>
                                            </div>
                                            <ul className="mt-2 space-y-1 text-xs text-slate-700">
                                                {track.items.map((item) => (
                                                    <li key={item} className="flex gap-2">
                                                        <span className="text-slate-400">•</span>
                                                        <span>{item}</span>
                                                    </li>
                                                ))}
                                            </ul>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    );
}
