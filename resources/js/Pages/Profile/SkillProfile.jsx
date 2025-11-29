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
        <div className="h-screen bg-gray-50 flex overflow-hidden">
            <Head title="Skill Profile" />

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
                    <Link href="/profile/skills" className="flex items-center px-4 py-3 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg group">
                        <svg className="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Skill Profile
                    </Link>
                    <a href="#" className="flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 group transition-colors">
                        <svg className="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Career Path
                    </a>
                </nav>

                <div className="p-4 border-t border-gray-200">
                    <div className="flex items-center gap-3 mb-4 px-2">
                        <div className="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                            {auth.user.name.charAt(0)}
                        </div>
                        <div className="flex-1 min-w-0">
                            <p className="text-sm font-medium text-gray-900 truncate">{auth.user.name}</p>
                            <p className="text-xs text-gray-500 truncate">{auth.user.email}</p>
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
                            <div className="max-w-6xl mx-auto animate-fade-in">
                                <div className="grid grid-cols-1 lg:grid-cols-12 gap-8">
                                    {/* Left Sidebar: Profile Card */}
                                    <div className="lg:col-span-4 space-y-6">
                                        <div className="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
                                            <div className="w-32 h-32 bg-gray-100 rounded-full mx-auto flex items-center justify-center text-4xl font-bold text-gray-600 mb-4 border-4 border-white shadow-sm">
                                                {auth.user.name.charAt(0).toUpperCase()}
                                            </div>
                                            <h2 className="text-xl font-bold text-gray-900 mb-1">{auth.user.name}</h2>
                                            <p className="text-sm text-gray-500 mb-6">{auth.user.email}</p>

                                            <button
                                                onClick={() => setCurrentStep(1)}
                                                className="w-full py-2.5 px-4 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors shadow-sm"
                                            >
                                                Edit Profile
                                            </button>
                                        </div>

                                        <div className="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                            <h3 className="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Profile Status</h3>
                                            <div className="flex items-center justify-between text-sm mb-2">
                                                <span className="text-gray-600">Profile Completion</span>
                                                <span className="font-medium text-green-600">100%</span>
                                            </div>
                                            <div className="w-full bg-gray-100 rounded-full h-2">
                                                <div className="bg-green-500 h-2 rounded-full w-full"></div>
                                            </div>
                                        </div>
                                    </div>

                                    {/* Right Column: Main Content */}
                                    <div className="lg:col-span-8 space-y-6">
                                        {/* Bio Section */}
                                        <div className="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                                            <div className="flex items-center justify-between mb-4 border-b border-gray-100 pb-4">
                                                <h3 className="text-lg font-bold text-gray-900">Professional Summary</h3>
                                                {userBioSummary && (
                                                    <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                        <svg className="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clipRule="evenodd" />
                                                        </svg>
                                                        AI Generated
                                                    </span>
                                                )}
                                            </div>
                                            <div className="text-gray-700 leading-relaxed whitespace-pre-wrap text-sm">
                                                {userBioSummary || userBio || (
                                                    <span className="text-gray-400 italic">No professional bio added yet.</span>
                                                )}
                                            </div>
                                        </div>

                                        {/* Skills Section */}
                                        <div className="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                                            <h3 className="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Technical Expertise</h3>

                                            <div className="space-y-8">
                                                {Object.keys(skills).map(category => {
                                                    const categorySkills = skills[category].filter(s => selectedSkills.includes(s.id));
                                                    if (categorySkills.length === 0) return null;

                                                    return (
                                                        <div key={category}>
                                                            <h4 className="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                                                <span className="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                                                {category}
                                                            </h4>
                                                            <div className="flex flex-wrap gap-2 pl-3.5">
                                                                {categorySkills.map(skill => (
                                                                    <span key={skill.id} className="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-gray-50 text-gray-700 border border-gray-200">
                                                                        {skill.name}
                                                                    </span>
                                                                ))}
                                                            </div>
                                                        </div>
                                                    );
                                                })}
                                                {selectedSkills.length === 0 && (
                                                    <p className="text-sm text-gray-400 italic">No skills selected yet.</p>
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
                                    <div className="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                                        <div className="flex items-center justify-between mb-6">
                                            <h2 className="text-lg font-semibold text-gray-900">Skill Library</h2>
                                            <div className="text-sm text-gray-500">
                                                {filteredSkills.length} skills available
                                            </div>
                                        </div>

                                        {/* Search Bar */}
                                        <div className="relative mb-6">
                                            <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg className="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                            </div>
                                            <input
                                                type="text"
                                                className="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors"
                                                placeholder="Search skills..."
                                                value={searchQuery}
                                                onChange={(e) => setSearchQuery(e.target.value)}
                                            />
                                        </div>

                                        {/* Category Tabs */}
                                        <div className="flex flex-wrap gap-2 mb-6 border-b border-gray-100 pb-4">
                                            {categories.map(category => (
                                                <button
                                                    key={category}
                                                    onClick={() => setActiveCategory(category)}
                                                    className={`px-3 py-1.5 rounded-md text-xs font-medium transition-colors ${
                                                        activeCategory === category
                                                            ? 'bg-gray-900 text-white'
                                                            : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                                                    }`}
                                                >
                                                    {category}
                                                </button>
                                            ))}
                                        </div>

                                        {/* Results Grid */}
                                        <div className="grid grid-cols-2 sm:grid-cols-3 gap-3 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                                            {filteredSkills.map(skill => (
                                                <button
                                                    key={skill.id}
                                                    onClick={() => handleAddSkill(skill.id)}
                                                    disabled={selectedSkills.includes(skill.id)}
                                                    className={`flex items-center justify-between p-3 rounded-lg border text-left transition-all ${
                                                        selectedSkills.includes(skill.id)
                                                            ? 'bg-gray-50 border-gray-200 opacity-60 cursor-default'
                                                            : 'bg-white border-gray-200 hover:border-indigo-500 hover:shadow-sm'
                                                    }`}
                                                >
                                                    <span className="text-sm font-medium text-gray-700">{skill.name}</span>
                                                    {!selectedSkills.includes(skill.id) && (
                                                        <svg className="w-4 h-4 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                    )}
                                                </button>
                                            ))}
                                            {filteredSkills.length === 0 && (
                                                <div className="col-span-full text-center py-12 text-gray-400 text-sm">
                                                    No skills found matching "{searchQuery}"
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                </div>

                                {/* Right Column: Your Stack */}
                                <div className="lg:col-span-5 space-y-6">
                                    <div className="bg-white p-6 rounded-lg shadow-sm border border-gray-200 h-full flex flex-col">
                                        <div className="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                                            <h2 className="text-lg font-semibold text-gray-900">Selected Skills</h2>
                                            <span className="bg-gray-100 text-gray-700 py-1 px-2.5 rounded-md text-xs font-bold">
                                                {selectedSkills.length}
                                            </span>
                                        </div>

                                        <div className="flex-1 overflow-y-auto pr-2 space-y-3 custom-scrollbar">
                                            {selectedSkills.length === 0 ? (
                                                <div className="h-64 flex flex-col items-center justify-center text-gray-400 border-2 border-dashed border-gray-200 rounded-lg bg-gray-50">
                                                    <svg className="w-10 h-10 mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                    </svg>
                                                    <p className="text-sm font-medium">No skills selected</p>
                                                    <p className="text-xs mt-1">Select from the library</p>
                                                </div>
                                            ) : (
                                                selectedSkills.map(skillId => {
                                                    const skill = allSkills.find(s => s.id === parseInt(skillId));
                                                    if (!skill) return null;

                                                    return (
                                                        <div key={skillId} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 group hover:bg-white hover:shadow-sm transition-all">
                                                            <div className="flex items-center gap-3">
                                                                <div className="w-8 h-8 rounded bg-white border border-gray-200 flex items-center justify-center text-gray-600 font-bold text-xs">
                                                                    {skill.name.substring(0, 2).toUpperCase()}
                                                                </div>
                                                                <div>
                                                                    <h4 className="text-sm font-medium text-gray-900">{skill.name}</h4>
                                                                    <p className="text-[10px] text-gray-500 uppercase tracking-wide">{skill.category}</p>
                                                                </div>
                                                            </div>
                                                            <button
                                                                onClick={() => handleRemoveSkill(skillId)}
                                                                className="text-gray-400 hover:text-red-500 p-1 rounded-md hover:bg-red-50 transition-colors"
                                                            >
                                                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
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
                                <div className="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                                    <div className="mb-8 pb-6 border-b border-gray-100">
                                        <h2 className="text-xl font-bold text-gray-900 mb-2">Professional Experience</h2>
                                        <p className="text-gray-500 text-sm">
                                            Detail your technical background and key achievements. This information helps tailor the simulation to your expertise level.
                                        </p>
                                    </div>

                                    <div className="space-y-8">
                                        <div>
                                            <label htmlFor="bio" className="block text-sm font-semibold text-gray-900 mb-3">
                                                Bio & Experience
                                            </label>
                                            <div className="relative">
                                                <textarea
                                                    id="bio"
                                                    rows="12"
                                                    className="block w-full p-4 border border-gray-300 rounded-lg focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none text-sm leading-relaxed"
                                                    placeholder="I am a Full Stack Developer with 3 years of experience..."
                                                    value={data.bio}
                                                    onChange={(e) => setData('bio', e.target.value)}
                                                ></textarea>
                                                <div className="absolute bottom-3 right-3 text-xs text-gray-400 bg-white px-2 py-1 rounded border border-gray-100">
                                                    {data.bio.length} chars
                                                </div>
                                            </div>
                                            {errors.bio && <div className="text-red-500 text-sm mt-2">{errors.bio}</div>}
                                            {errors.skills && <div className="text-red-500 text-sm mt-2">{errors.skills}</div>}
                                        </div>

                                        <div className="bg-gray-50 rounded-lg p-5 border border-gray-200">
                                            <h4 className="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Skills Referenced</h4>
                                            <div className="flex flex-wrap gap-2">
                                                {selectedSkills.map(skillId => {
                                                    const skill = allSkills.find(s => s.id === parseInt(skillId));
                                                    return skill ? (
                                                        <span key={skillId} className="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-white text-gray-700 border border-gray-200 shadow-sm">
                                                            {skill.name}
                                                        </span>
                                                    ) : null;
                                                })}
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
