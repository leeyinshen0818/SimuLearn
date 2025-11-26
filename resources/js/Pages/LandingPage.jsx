import React from 'react';
import { Head, Link } from '@inertiajs/react';

const LandingPage = ({ auth }) => {
    return (
        <div className="min-h-screen bg-gray-50 font-sans text-gray-900">
            <Head title="Welcome" />

            {/* Navigation */}
            <nav className="bg-white/80 backdrop-blur-md fixed w-full z-50 border-b border-gray-100">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-16">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 flex items-center gap-2">
                                <div className="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                                    <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <span className="text-2xl font-bold bg-clip-text text-transparent bg-linear-to-r from-indigo-600 to-violet-600">
                                    SimuLearn
                                </span>
                            </div>
                        </div>
                        <div className="flex items-center space-x-4">
                            {auth?.user ? (
                                <Link href="/dashboard" className="bg-indigo-600 text-white px-5 py-2.5 rounded-full text-sm font-medium hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition-all hover:scale-105">
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link href="/login" className="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                        Login
                                    </Link>
                                    <Link href="/register" className="bg-indigo-600 text-white px-5 py-2.5 rounded-full text-sm font-medium hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition-all hover:scale-105">
                                        Get Started
                                    </Link>
                                </>
                            )}
                        </div>
                    </div>
                </div>
            </nav>

            {/* Hero Section */}
            <div className="relative pt-16 pb-16 lg:pb-24 overflow-hidden">
                <div className="absolute inset-0">
                    <div className="absolute inset-0 bg-linear-to-br from-indigo-50 via-white to-violet-50 opacity-90"></div>
                    <div className="absolute right-0 top-0 -mt-20 -mr-20 w-96 h-96 bg-indigo-100 rounded-full blur-3xl opacity-50"></div>
                    <div className="absolute left-0 bottom-0 -mb-20 -ml-20 w-96 h-96 bg-violet-100 rounded-full blur-3xl opacity-50"></div>
                </div>

                <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 lg:mt-24">
                    <div className="lg:grid lg:grid-cols-12 lg:gap-8">
                        <div className="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                            <div className="inline-flex items-center px-3 py-1 rounded-full border border-indigo-100 bg-indigo-50 text-indigo-600 text-sm font-medium mb-6">
                                <span className="flex h-2 w-2 rounded-full bg-indigo-600 mr-2"></span>
                                AI-Powered Career Growth
                            </div>
                            <h1 className="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl lg:text-5xl xl:text-6xl">
                                <span className="block">Bridge the gap between</span>
                                <span className="block text-transparent bg-clip-text bg-linear-to-r from-indigo-600 to-violet-600">
                                    Theory & Industry
                                </span>
                            </h1>
                            <p className="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                SimuLearn acts as your AI Senior Project Manager. We don't just teach you code; we simulate the real-world work environment to make you job-ready.
                            </p>
                            <div className="mt-8 sm:max-w-lg sm:mx-auto sm:text-center lg:text-left lg:mx-0">
                                <div className="flex flex-col sm:flex-row gap-4">
                                    <button className="flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg shadow-lg shadow-indigo-500/30 transition-all hover:scale-105">
                                        Start Simulation
                                        <svg className="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </button>
                                    <button className="flex items-center justify-center px-8 py-3 border border-gray-200 text-base font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 md:py-4 md:text-lg transition-all hover:border-indigo-200">
                                        View Demo
                                    </button>
                                </div>
                                <p className="mt-3 text-sm text-gray-500">
                                    No credit card required · Free for students
                                </p>
                            </div>
                        </div>
                        <div className="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                            <div className="relative mx-auto w-full rounded-2xl shadow-2xl lg:max-w-md overflow-hidden group">
                                <div className="absolute inset-0 bg-linear-to-tr from-indigo-600 to-violet-600 opacity-10 group-hover:opacity-20 transition-opacity"></div>
                                <div className="relative bg-white p-6 h-96 flex flex-col">
                                    {/* Mock UI for Simulation */}
                                    <div className="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                                        <div className="flex items-center gap-2">
                                            <div className="w-3 h-3 rounded-full bg-red-400"></div>
                                            <div className="w-3 h-3 rounded-full bg-yellow-400"></div>
                                            <div className="w-3 h-3 rounded-full bg-green-400"></div>
                                        </div>
                                        <div className="text-xs font-mono text-gray-400">project-dashboard.tsx</div>
                                    </div>

                                    <div className="space-y-4 flex-1">
                                        <div className="flex items-start gap-3">
                                            <div className="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center shrink-0">
                                                <span className="text-xs font-bold text-indigo-600">AI</span>
                                            </div>
                                            <div className="bg-gray-50 rounded-lg p-3 text-sm text-gray-600 w-full">
                                                <p className="font-medium text-gray-900 mb-1">New Task Assigned</p>
                                                <p>Based on your skills, I've unlocked the "Database Schema Design" module. Ready to start?</p>
                                            </div>
                                        </div>

                                        <div className="flex items-center justify-end gap-2 mt-4">
                                            <div className="h-2 w-24 bg-gray-100 rounded-full overflow-hidden">
                                                <div className="h-full w-2/3 bg-green-500 rounded-full"></div>
                                            </div>
                                            <span className="text-xs text-gray-500">65% Complete</span>
                                        </div>

                                        <div className="grid grid-cols-2 gap-3 mt-4">
                                            <div className="border border-indigo-100 bg-indigo-50/50 p-3 rounded-lg">
                                                <div className="text-xs text-indigo-600 font-medium mb-1">Next Task</div>
                                                <div className="text-sm font-bold text-gray-800">API Integration</div>
                                            </div>
                                            <div className="border border-gray-100 bg-gray-50 p-3 rounded-lg opacity-60">
                                                <div className="text-xs text-gray-500 font-medium mb-1">Locked</div>
                                                <div className="text-sm font-bold text-gray-400">Frontend UI</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* Feature Section */}
            <div className="py-16 bg-white relative">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center">
                        <h2 className="text-base text-indigo-600 font-semibold tracking-wide uppercase">Features</h2>
                        <p className="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                            A Better Way to Learn
                        </p>
                        <p className="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                            Stop watching tutorials. Start building real software with an AI mentor guiding your every step.
                        </p>
                    </div>

                    <div className="mt-16">
                        <div className="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                            {/* Feature 1 */}
                            <div className="pt-6">
                                <div className="flow-root bg-gray-50 rounded-2xl px-6 pb-8">
                                    <div className="-mt-6">
                                        <div>
                                            <span className="inline-flex items-center justify-center p-3 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-500/30">
                                                <svg className="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </span>
                                        </div>
                                        <h3 className="mt-8 text-lg font-medium text-gray-900 tracking-tight">Smart Matching</h3>
                                        <p className="mt-5 text-base text-gray-500">
                                            Input your syllabus and skills. Our AI finds the perfect project that fits your current level, ensuring you're never bored or overwhelmed.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {/* Feature 2 */}
                            <div className="pt-6">
                                <div className="flow-root bg-gray-50 rounded-2xl px-6 pb-8">
                                    <div className="-mt-6">
                                        <div>
                                            <span className="inline-flex items-center justify-center p-3 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-500/30">
                                                <svg className="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <h3 className="mt-8 text-lg font-medium text-gray-900 tracking-tight">Guided Simulation</h3>
                                        <p className="mt-5 text-base text-gray-500">
                                            Experience a real workflow. Tasks are unlocked sequentially based on dependencies (DAG), simulating a real Agile development cycle.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {/* Feature 3 */}
                            <div className="pt-6">
                                <div className="flow-root bg-gray-50 rounded-2xl px-6 pb-8">
                                    <div className="-mt-6">
                                        <div>
                                            <span className="inline-flex items-center justify-center p-3 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-500/30">
                                                <svg className="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <h3 className="mt-8 text-lg font-medium text-gray-900 tracking-tight">Career Analytics</h3>
                                        <p className="mt-5 text-base text-gray-500">
                                            We analyze your performance to suggest the best career path for you—Frontend, Backend, or DevOps—based on where you excel.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* Footer */}
            <footer className="bg-gray-900 text-white py-12">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div className="col-span-1 md:col-span-2">
                            <div className="flex items-center gap-2 mb-4">
                                <div className="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                                    <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <span className="text-2xl font-bold">SimuLearn</span>
                            </div>
                            <p className="text-gray-400 max-w-sm">
                                Empowering the next generation of developers through AI-driven industry simulations.
                            </p>
                        </div>
                        <div>
                            <h4 className="text-lg font-semibold mb-4">Platform</h4>
                            <ul className="space-y-2 text-gray-400">
                                <li><a href="#" className="hover:text-white transition-colors">Projects</a></li>
                                <li><a href="#" className="hover:text-white transition-colors">Mentorship</a></li>
                                <li><a href="#" className="hover:text-white transition-colors">Pricing</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 className="text-lg font-semibold mb-4">Company</h4>
                            <ul className="space-y-2 text-gray-400">
                                <li><a href="#" className="hover:text-white transition-colors">About Us</a></li>
                                <li><a href="#" className="hover:text-white transition-colors">Careers</a></li>
                                <li><a href="#" className="hover:text-white transition-colors">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <div className="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500">
                        <p>&copy; 2025 SimuLearn. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>
    );
};

export default LandingPage;
