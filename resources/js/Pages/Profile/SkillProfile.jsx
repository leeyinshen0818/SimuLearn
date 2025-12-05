import React, { useState, useMemo, useEffect } from 'react';
import { Head, useForm, Link } from '@inertiajs/react';

const SkillProfile = ({ auth, skills, userSkills, userBio, userBioSummary }) => {
    // Flatten skills for global search
    const allSkills = useMemo(() => {
        let flat = [];
        Object.keys(skills).forEach(category => {
            flat = [...flat, ...skills[category].map(s => ({ ...s, category }))];
        });
        return flat;
    }, [skills]);

    // Transform userSkills array into a list of IDs
    const initialSkills = userSkills.map(s => s.id);

    const { data, setData, post, processing, errors } = useForm({
        skills: initialSkills,
        bio: userBio || ''
    });

    const [selectedSkills, setSelectedSkills] = useState(initialSkills);
    const [searchQuery, setSearchQuery] = useState('');
    const [activeCategory, setActiveCategory] = useState('All');
    const [currentStep, setCurrentStep] = useState(initialSkills.length > 0 || userBio ? 3 : 1);

    // Sync local state with props when they update (e.g. after save)
    useEffect(() => {
        const updatedSkillIds = userSkills.map(s => s.id);
        setSelectedSkills(updatedSkillIds);
        setData(prevData => ({
            ...prevData,
            skills: updatedSkillIds,
            bio: userBio || ''
        }));
    }, [userSkills, userBio]);

    // Filter skills based on search and category
    const filteredSkills = allSkills.filter(skill => {
        const matchesSearch = skill.name.toLowerCase().includes(searchQuery.toLowerCase());
        const matchesCategory = activeCategory === 'All' || skill.category === activeCategory;
        return matchesSearch && matchesCategory;
    });

    const handleAddSkill = (skillId) => {
        if (!selectedSkills.includes(skillId)) {
            const newSelectedSkills = [...selectedSkills, skillId];
            setSelectedSkills(newSelectedSkills);
            setData('skills', newSelectedSkills);
            setSearchQuery(''); // Clear search after adding
        }
    };

    const handleRemoveSkill = (skillId) => {
        const newSelectedSkills = selectedSkills.filter(id => id !== skillId);
        setSelectedSkills(newSelectedSkills);
        setData('skills', newSelectedSkills);
    };

    const submit = (e) => {
        e.preventDefault();
        post('/profile/skills', {
            preserveScroll: true,
            onSuccess: () => {
                setCurrentStep(3);
            },
            onError: (errors) => {
                console.error('Submission errors:', errors);
            }
        });
    };

    const handleCancel = () => {
        if (initialSkills.length > 0 || userBio) {
            setCurrentStep(3);
            setSelectedSkills(initialSkills);
            setData(prev => ({
                ...prev,
                skills: initialSkills,
                bio: userBio || ''
            }));
        } else {
            window.location.href = '/dashboard';
        }
    };

    const categories = ['All', ...Object.keys(skills)];

    return (
        <div className="h-screen bg-slate-50 flex overflow-hidden font-sans">
            <Head title="Skill Profile" />

            {/* Sidebar */}
            <div className="w-72 bg-white border-r border-slate-200 flex flex-col shrink-0 z-20">
                <div className="h-16 flex items-center px-8 border-b border-slate-100">
                    <Link href="/" className="flex items-center gap-3 group">
                        <div className="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-indigo-200 shadow-md group-hover:scale-105 transition-transform">
                            <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span className="text-xl font-bold text-slate-900 tracking-tight">SimuLearn</span>
                    </Link>
                </div>

                <nav className="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                    <Link href="/dashboard" className="flex items-center px-4 py-3 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-50 hover:text-slate-900 group transition-all">
                        <svg className="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </Link>
                    <Link href="/my-projects" className="flex items-center px-4 py-3 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-50 hover:text-slate-900 group transition-all">
                        <svg className="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        My Projects
                    </Link>
                    <Link href="/profile/skills" className="flex items-center px-4 py-3 text-sm font-medium text-slate-900 bg-white border border-slate-200 shadow-sm rounded-lg group relative overflow-hidden">
                        <div className="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-l-lg"></div>
                        <svg className="w-5 h-5 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Skill Profile
                    </Link>
                    <a href="#" className="flex items-center px-4 py-3 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-50 hover:text-slate-900 group transition-all">
                        <svg className="w-5 h-5 mr-3 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Career Path
                    </a>
                </nav>

                <div className="p-4 border-t border-slate-200">
                    <div className="flex items-center gap-3 mb-4 px-2">
                        <div className="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-bold shadow-sm">
                            {auth.user.name.charAt(0)}
                        </div>
                        <div className="flex-1 min-w-0">
                            <p className="text-sm font-semibold text-slate-900 truncate">{auth.user.name}</p>
                            <p className="text-xs text-slate-500 truncate">{auth.user.email}</p>
                        </div>
                    </div>
                    <Link
                        href="/logout"
                        method="post"
                        as="button"
                        className="w-full flex items-center justify-center px-4 py-2 border border-slate-300 shadow-sm text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all"
                    >
                        Log Out
                    </Link>
                </div>
            </div>

            {/* Main Content */}
            <div className="flex-1 flex flex-col overflow-hidden">
                <header className="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8 shrink-0">
                    <div className="flex items-center gap-4">
                        <h1 className="text-xl font-bold text-gray-900">
                            {currentStep === 3 ? 'Your Profile' : 'Build Your Profile'}
                        </h1>
                        {currentStep !== 3 && (
                            <div className="flex items-center gap-2 text-sm font-medium ml-4">
                                <span className={`flex items-center gap-2 px-3 py-1 rounded-md transition-colors ${currentStep === 1 ? 'bg-indigo-50 text-indigo-700' : 'text-gray-400'}`}>
                                    <span className={`w-5 h-5 rounded-full flex items-center justify-center text-xs border ${currentStep === 1 ? 'border-indigo-200 bg-white' : 'border-gray-200'}`}>1</span>
                                    Skills
                                </span>
                                <span className="text-gray-300">/</span>
                                <span className={`flex items-center gap-2 px-3 py-1 rounded-md transition-colors ${currentStep === 2 ? 'bg-indigo-50 text-indigo-700' : 'text-gray-400'}`}>
                                    <span className={`w-5 h-5 rounded-full flex items-center justify-center text-xs border ${currentStep === 2 ? 'border-indigo-200 bg-white' : 'border-gray-200'}`}>2</span>
                                    Experience
                                </span>
                            </div>
                        )}
                    </div>
                    <div className="flex items-center gap-3">
                        {currentStep !== 3 && (
                            <button
                                onClick={handleCancel}
                                className="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors"
                            >
                                Cancel
                            </button>
                        )}
                        {currentStep === 1 && (
                            <button
                                onClick={() => setCurrentStep(2)}
                                disabled={selectedSkills.length === 0}
                                className="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                Next Step
                            </button>
                        )}
                        {currentStep === 2 && (
                            <>
                                <button
                                    onClick={() => setCurrentStep(1)}
                                    className="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all"
                                >
                                    Back
                                </button>
                                <button
                                    onClick={submit}
                                    disabled={processing}
                                    className="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all"
                                >
                                    {processing ? 'Saving...' : 'Save Profile'}
                                </button>
                            </>
                        )}
                    </div>
                </header>

                <main className="flex-1 overflow-y-auto p-8 bg-gray-50/50">
                    <div className="max-w-6xl mx-auto">
                        {currentStep === 3 && (
                            <div className="max-w-6xl mx-auto animate-fade-in space-y-8">
                                {/* Top Section: Profile Header & Status */}
                                <div className="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                                    <div className="h-32 bg-gradient-to-r from-indigo-600 to-purple-600 relative">
                                        <div className="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                                    </div>
                                    <div className="px-8 pb-8">
                                        <div className="flex flex-col md:flex-row items-start md:items-end -mt-12 gap-6 relative z-10">
                                            <div className="w-32 h-32 bg-white rounded-full p-1.5 shadow-lg ring-1 ring-slate-100 shrink-0">
                                                <div className="w-full h-full bg-slate-100 rounded-full flex items-center justify-center text-4xl font-bold text-indigo-600">
                                                    {auth.user.name.charAt(0).toUpperCase()}
                                                </div>
                                            </div>

                                            <div className="flex-1 min-w-0 pt-2 md:pt-0 md:pb-2">
                                                <h2 className="text-2xl font-bold text-slate-900">{auth.user.name}</h2>
                                                <p className="text-slate-500 font-medium">{auth.user.email}</p>
                                            </div>

                                            <div className="flex items-center gap-6 w-full md:w-auto pt-4 md:pt-0 border-t md:border-t-0 border-slate-100 md:pb-3">
                                                <div className="flex-1 md:flex-none">
                                                    <div className="flex items-center justify-between gap-8 mb-1.5">
                                                        <span className="text-xs font-bold text-slate-500 uppercase tracking-wider">Profile Completion</span>
                                                        <span className="text-sm font-bold text-emerald-600">100%</span>
                                                    </div>
                                                    <div className="w-full md:w-48 bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                                        <div className="bg-emerald-500 h-full rounded-full w-full shadow-[0_0_10px_rgba(16,185,129,0.3)]"></div>
                                                    </div>
                                                </div>
                                                <button
                                                    onClick={() => setCurrentStep(1)}
                                                    className="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm shadow-indigo-200 transition-all flex items-center gap-2 shrink-0"
                                                >
                                                    <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                    Edit Profile
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div className="grid grid-cols-1 lg:grid-cols-12 gap-8">
                                    {/* Left Column: Bio & Analysis */}
                                    <div className="lg:col-span-7 space-y-8">
                                        {/* Bio Section */}
                                        <div className="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
                                            <div className="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
                                                <h3 className="text-lg font-bold text-slate-900 flex items-center gap-2">
                                                    <svg className="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    Professional Bio
                                                </h3>
                                            </div>
                                            <div className="text-slate-600 leading-relaxed whitespace-pre-wrap text-sm">
                                                {userBio || (
                                                    <span className="text-slate-400 italic">No professional bio added yet.</span>
                                                )}
                                            </div>
                                        </div>

                                        {/* AI Analysis Section */}
                                        {userBioSummary && (
                                            <div className="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                                                <div className="bg-slate-50 px-8 py-4 border-b border-slate-200 flex items-center justify-between">
                                                    <h3 className="text-sm font-bold text-slate-800 uppercase tracking-wide flex items-center gap-2">
                                                        <svg className="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                                        </svg>
                                                        Capability Analysis
                                                    </h3>
                                                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-white text-slate-600 border border-slate-200 shadow-sm">
                                                        <span className="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                                                        AI Generated
                                                    </span>
                                                </div>
                                                <div className="p-8">
                                                    <div className="prose prose-sm max-w-none text-slate-600 leading-relaxed">
                                                        {userBioSummary.split('\n').map((line, i) => {
                                                            // Remove markdown bold markers
                                                            const cleanLine = line.replace(/\*\*/g, '').trim();
                                                            if (!cleanLine) return null;

                                                            // Check if it's a list item (starts with * or • or -)
                                                            const isListItem = cleanLine.startsWith('*') || cleanLine.startsWith('•') || cleanLine.startsWith('-');

                                                            // Remove the bullet marker for display
                                                            const displayLine = cleanLine.replace(/^[\*•-]\s*/, '');

                                                            // Check if it's a header (ends with :)
                                                            const isHeader = displayLine.endsWith(':');

                                                            if (isHeader) {
                                                                return <h4 key={i} className="font-bold text-slate-900 mt-4 first:mt-0 mb-2">{displayLine}</h4>;
                                                            }

                                                            if (isListItem) {
                                                                return (
                                                                    <div key={i} className="flex items-start gap-2.5 mb-2 pl-1">
                                                                        <span className="w-1.5 h-1.5 rounded-full bg-indigo-500 mt-2 shrink-0"></span>
                                                                        <span className="text-slate-700">{displayLine}</span>
                                                                    </div>
                                                                );
                                                            }

                                                            return <p key={i} className="mb-2">{displayLine}</p>;
                                                        })}
                                                    </div>
                                                </div>
                                            </div>
                                        )}
                                    </div>

                                    {/* Right Column: Skills */}
                                    <div className="lg:col-span-5">
                                        <div className="bg-white rounded-xl shadow-sm border border-slate-200 p-8 h-full">
                                            <div className="flex items-center justify-between mb-8 border-b border-slate-100 pb-4">
                                                <h3 className="text-lg font-bold text-slate-900 flex items-center gap-2">
                                                    <svg className="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                                    </svg>
                                                    Technical Expertise
                                                </h3>
                                                <span className="text-xs font-medium text-slate-500 bg-slate-50 px-3 py-1 rounded-full border border-slate-200">
                                                    {selectedSkills.length} Skills
                                                </span>
                                            </div>

                                            <div className="space-y-10">
                                                {Object.keys(skills).map(category => {
                                                    const categorySkills = skills[category].filter(s => selectedSkills.includes(s.id));
                                                    if (categorySkills.length === 0) return null;

                                                    return (
                                                        <div key={category}>
                                                            <h4 className="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-3">
                                                                {category}
                                                                <span className="h-px flex-1 bg-slate-100"></span>
                                                            </h4>
                                                            <div className="flex flex-wrap gap-3">
                                                                {categorySkills.map(skill => (
                                                                    <span key={skill.id} className="inline-flex items-center px-3.5 py-1.5 rounded-lg text-sm font-medium bg-white text-slate-700 border border-slate-200 shadow-sm hover:border-indigo-300 hover:shadow-md transition-all cursor-default">
                                                                        {skill.name}
                                                                    </span>
                                                                ))}
                                                            </div>
                                                        </div>
                                                    );
                                                })}
                                                {selectedSkills.length === 0 && (
                                                    <div className="text-center py-12 bg-slate-50 rounded-lg border-2 border-dashed border-slate-200">
                                                        <p className="text-sm text-slate-500">No technical skills recorded.</p>
                                                    </div>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        )}

                        {currentStep === 1 && (
                            <div className="grid grid-cols-1 lg:grid-cols-12 gap-8">
                                {/* Left Column: Search & Discovery */}
                                <div className="lg:col-span-7 space-y-6">
                                    <div className="bg-white p-8 rounded-xl shadow-sm border border-slate-200">
                                        <div className="flex items-center justify-between mb-6">
                                            <div>
                                                <h2 className="text-lg font-bold text-slate-900">Skill Library</h2>
                                                <p className="text-sm text-slate-500 mt-1">Select skills to add to your profile</p>
                                            </div>
                                            <div className="text-xs font-medium text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                                                {filteredSkills.length} available
                                            </div>
                                        </div>

                                        {/* Search Bar */}
                                        <div className="relative mb-6 group">
                                            <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <svg className="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                            </div>
                                            <input
                                                type="text"
                                                className="block w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm transition-all"
                                                placeholder="Search for technologies, frameworks, or tools..."
                                                value={searchQuery}
                                                onChange={(e) => setSearchQuery(e.target.value)}
                                            />
                                        </div>

                                        {/* Category Tabs */}
                                        <div className="flex flex-wrap gap-2 mb-6 border-b border-slate-100 pb-6">
                                            {categories.map(category => (
                                                <button
                                                    key={category}
                                                    onClick={() => setActiveCategory(category)}
                                                    className={`px-4 py-2 rounded-lg text-xs font-semibold transition-all ${
                                                        activeCategory === category
                                                            ? 'bg-slate-900 text-white shadow-md shadow-slate-200'
                                                            : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300 hover:bg-slate-50'
                                                    }`}
                                                >
                                                    {category}
                                                </button>
                                            ))}
                                        </div>

                                        {/* Results Grid */}
                                        <div className="grid grid-cols-2 sm:grid-cols-3 gap-3 max-h-[450px] overflow-y-auto pr-2 custom-scrollbar">
                                            {filteredSkills.map(skill => (
                                                <button
                                                    key={skill.id}
                                                    onClick={() => handleAddSkill(skill.id)}
                                                    disabled={selectedSkills.includes(skill.id)}
                                                    className={`flex items-center justify-between p-3.5 rounded-xl border text-left transition-all duration-200 ${
                                                        selectedSkills.includes(skill.id)
                                                            ? 'bg-slate-50 border-slate-100 opacity-50 cursor-default'
                                                            : 'bg-white border-slate-200 hover:border-indigo-500 hover:shadow-md hover:shadow-indigo-500/5 group'
                                                    }`}
                                                >
                                                    <span className={`text-sm font-medium ${selectedSkills.includes(skill.id) ? 'text-slate-400' : 'text-slate-700 group-hover:text-slate-900'}`}>
                                                        {skill.name}
                                                    </span>
                                                    {!selectedSkills.includes(skill.id) && (
                                                        <div className="w-6 h-6 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-indigo-50 transition-colors">
                                                            <svg className="w-3.5 h-3.5 text-slate-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4v16m8-8H4" />
                                                            </svg>
                                                        </div>
                                                    )}
                                                </button>
                                            ))}
                                            {filteredSkills.length === 0 && (
                                                <div className="col-span-full flex flex-col items-center justify-center py-16 text-slate-400">
                                                    <svg className="w-12 h-12 mb-3 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                    </svg>
                                                    <p className="text-sm font-medium">No skills found matching "{searchQuery}"</p>
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                </div>

                                {/* Right Column: Your Stack */}
                                <div className="lg:col-span-5 space-y-6">
                                    <div className="bg-white p-8 rounded-xl shadow-sm border border-slate-200 h-full flex flex-col">
                                        <div className="flex items-center justify-between mb-6 pb-6 border-b border-slate-100">
                                            <div>
                                                <h2 className="text-lg font-bold text-slate-900">Selected Stack</h2>
                                                <p className="text-sm text-slate-500 mt-1">Your technical profile</p>
                                            </div>
                                            <span className="bg-indigo-50 text-indigo-700 py-1 px-3 rounded-full text-xs font-bold border border-indigo-100">
                                                {selectedSkills.length}
                                            </span>
                                        </div>

                                        <div className="flex-1 overflow-y-auto pr-2 space-y-3 custom-scrollbar">
                                            {selectedSkills.length === 0 ? (
                                                <div className="h-64 flex flex-col items-center justify-center text-slate-400 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                                                    <div className="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm border border-slate-100">
                                                        <svg className="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                        </svg>
                                                    </div>
                                                    <p className="text-sm font-semibold text-slate-600">No skills selected</p>
                                                    <p className="text-xs mt-1">Select skills from the library to build your stack</p>
                                                </div>
                                            ) : (
                                                selectedSkills.map(skillId => {
                                                    const skill = allSkills.find(s => s.id === parseInt(skillId));
                                                    if (!skill) return null;

                                                    return (
                                                        <div key={skillId} className="flex items-center justify-between p-3 bg-white rounded-xl border border-slate-200 group hover:border-indigo-300 hover:shadow-md hover:shadow-indigo-500/5 transition-all duration-200">
                                                            <div className="flex items-center gap-3">
                                                                <div className="w-10 h-10 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-600 font-bold text-xs group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                                                                    {skill.name.substring(0, 2).toUpperCase()}
                                                                </div>
                                                                <div>
                                                                    <h4 className="text-sm font-semibold text-slate-900">{skill.name}</h4>
                                                                    <p className="text-[10px] text-slate-500 uppercase tracking-wide font-medium">{skill.category}</p>
                                                                </div>
                                                            </div>
                                                            <button
                                                                onClick={() => handleRemoveSkill(skillId)}
                                                                className="text-slate-300 hover:text-red-500 p-2 rounded-lg hover:bg-red-50 transition-all"
                                                                title="Remove skill"
                                                            >
                                                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    );
                                                })
                                            )}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        )}

                        {currentStep === 2 && (
                            <div className="max-w-3xl mx-auto">
                                <div className="bg-white p-8 rounded-xl shadow-sm border border-slate-200">
                                    <div className="mb-8 pb-6 border-b border-slate-100">
                                        <h2 className="text-xl font-bold text-slate-900 mb-2">Professional Experience</h2>
                                        <p className="text-slate-500 text-sm">
                                            Detail your technical background and key achievements. This information helps tailor the simulation to your expertise level.
                                        </p>
                                    </div>

                                    <div className="space-y-8">
                                        <div>
                                            <label htmlFor="bio" className="block text-sm font-bold text-slate-900 mb-3">
                                                Bio & Experience
                                            </label>
                                            <div className="relative">
                                                <textarea
                                                    id="bio"
                                                    rows="12"
                                                    className="block w-full p-4 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all resize-none text-sm leading-relaxed bg-slate-50 focus:bg-white placeholder-slate-400"
                                                    placeholder="I am a Full Stack Developer with 3 years of experience..."
                                                    value={data.bio}
                                                    onChange={(e) => setData('bio', e.target.value)}
                                                ></textarea>
                                                <div className="absolute bottom-3 right-3 text-xs font-medium text-slate-400 bg-white/80 backdrop-blur-sm px-2 py-1 rounded border border-slate-100 shadow-sm">
                                                    {data.bio.length} chars
                                                </div>
                                            </div>
                                            {errors.bio && <div className="text-red-500 text-sm mt-2 font-medium">{errors.bio}</div>}
                                            {errors.skills && <div className="text-red-500 text-sm mt-2 font-medium">{errors.skills}</div>}
                                        </div>

                                        <div className="bg-slate-50 rounded-xl p-6 border border-slate-200">
                                            <h4 className="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                                Skills Referenced
                                            </h4>
                                            <div className="flex flex-wrap gap-2">
                                                {selectedSkills.map(skillId => {
                                                    const skill = allSkills.find(s => s.id === parseInt(skillId));
                                                    return skill ? (
                                                        <span key={skillId} className="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-white text-slate-700 border border-slate-200 shadow-sm">
                                                            {skill.name}
                                                        </span>
                                                    ) : null;
                                                })}
                                                {selectedSkills.length === 0 && (
                                                    <span className="text-sm text-slate-400 italic">No skills selected yet.</span>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>
                </main>
            </div>
        </div>
    );
};

export default SkillProfile;
