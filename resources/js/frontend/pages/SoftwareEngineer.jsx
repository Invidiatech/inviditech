import React, { useState } from 'react';

const SoftwareEngineer = ({ isDarkMode }) => {
    const developmentPhases = [
        {
            phase: '1. Discovery & Planning',
            title: 'From Idea to Requirements',
            description: 'Understanding your vision and defining clear, actionable requirements',
            activities: [
                'Initial consultation to understand business goals',
                'Gather functional and technical requirements',
                'Define success metrics and KPIs',
                'Create project timeline and milestones',
                'Identify potential technical challenges'
            ],
            deliverables: ['Requirements document', 'Project proposal', 'Timeline estimate', 'Cost breakdown'],
            duration: '1-2 weeks',
            icon: 'fas fa-lightbulb',
            color: 'from-blue-500 to-cyan-500'
        },
        {
            phase: '2. Design & Architecture',
            title: 'Planning the Technical Solution',
            description: 'Designing scalable architecture and user-friendly interfaces',
            activities: [
                'Database schema design and ERD creation',
                'API endpoint planning and documentation',
                'UI/UX wireframes and mockups',
                'Technology stack selection',
                'Security and scalability planning'
            ],
            deliverables: ['System architecture diagram', 'Database schema', 'API documentation', 'UI mockups'],
            duration: '1-2 weeks',
            icon: 'fas fa-drafting-compass',
            color: 'from-purple-500 to-pink-500'
        },
        {
            phase: '3. Development',
            title: 'Building the Application',
            description: 'Writing clean, tested code following best practices',
            activities: [
                'Set up development environment and CI/CD',
                'Backend API development with Laravel',
                'Database implementation and migrations',
                'Frontend development with React/Vue',
                'Third-party integrations (payments, APIs)',
                'Write unit and integration tests'
            ],
            deliverables: ['Working application', 'Test coverage', 'Code documentation', 'API endpoints'],
            duration: '4-12 weeks',
            icon: 'fas fa-code',
            color: 'from-green-500 to-emerald-500'
        },
        {
            phase: '4. Testing & QA',
            title: 'Ensuring Quality & Reliability',
            description: 'Thorough testing to catch bugs before production',
            activities: [
                'Manual testing of all features',
                'Automated test suite execution',
                'Performance and load testing',
                'Security vulnerability scanning',
                'Cross-browser and device testing',
                'Bug fixing and refinement'
            ],
            deliverables: ['Test reports', 'Bug fixes', 'Performance benchmarks', 'Security audit'],
            duration: '1-2 weeks',
            icon: 'fas fa-check-circle',
            color: 'from-yellow-500 to-orange-500'
        },
        {
            phase: '5. Deployment',
            title: 'Going Live to Production',
            description: 'Deploying to production environment safely',
            activities: [
                'Server setup and configuration',
                'Database migration and seeding',
                'SSL certificate installation',
                'Environment configuration',
                'DNS setup and CDN configuration',
                'Final smoke tests on production'
            ],
            deliverables: ['Live application', 'Deployment documentation', 'Server credentials', 'Monitoring setup'],
            duration: '3-5 days',
            icon: 'fas fa-rocket',
            color: 'from-red-500 to-pink-500'
        },
        {
            phase: '6. Maintenance & Support',
            title: 'Ongoing Support & Updates',
            description: 'Keeping your application secure, fast, and up-to-date',
            activities: [
                'Monitor application performance',
                'Fix bugs and security patches',
                'Performance optimization',
                'Feature enhancements',
                'Dependency updates',
                'Regular backups and disaster recovery'
            ],
            deliverables: ['Bug fixes', 'Performance reports', 'Security updates', 'New features'],
            duration: 'Ongoing',
            icon: 'fas fa-tools',
            color: 'from-indigo-500 to-purple-500'
        }
    ];

    const bestPractices = [
        {
            title: 'Version Control',
            description: 'All code tracked with Git, proper branching strategy',
            icon: 'fab fa-git-alt'
        },
        {
            title: 'Code Reviews',
            description: 'Every change reviewed for quality and security',
            icon: 'fas fa-code-branch'
        },
        {
            title: 'Automated Testing',
            description: 'Unit, integration, and feature tests for reliability',
            icon: 'fas fa-vial'
        },
        {
            title: 'CI/CD Pipeline',
            description: 'Automated deployment with quality gates',
            icon: 'fas fa-sync-alt'
        },
        {
            title: 'Documentation',
            description: 'Code comments, API docs, and user guides',
            icon: 'fas fa-book'
        },
        {
            title: 'Security First',
            description: 'Input validation, authentication, encryption',
            icon: 'fas fa-shield-alt'
        },
        {
            title: 'Performance',
            description: 'Caching, query optimization, lazy loading',
            icon: 'fas fa-tachometer-alt'
        },
        {
            title: 'Monitoring',
            description: 'Error tracking, performance monitoring, alerts',
            icon: 'fas fa-chart-line'
        }
    ];

    const technicalStack = [
        {
            category: 'Backend Development',
            technologies: ['Laravel 10+', 'PHP 8.2+', 'RESTful APIs', 'GraphQL', 'WebSockets'],
            icon: 'fas fa-server'
        },
        {
            category: 'Database Management',
            technologies: ['MySQL', 'PostgreSQL', 'Redis', 'Database Design', 'Query Optimization'],
            icon: 'fas fa-database'
        },
        {
            category: 'Frontend Development',
            technologies: ['React', 'Vue.js', 'Tailwind CSS', 'JavaScript ES6+', 'Responsive Design'],
            icon: 'fas fa-desktop'
        },
        {
            category: 'DevOps & Deployment',
            technologies: ['Docker', 'GitHub Actions', 'AWS/DigitalOcean', 'Nginx', 'Linux'],
            icon: 'fas fa-cloud'
        }
    ];

    const developmentPrinciples = [
        'Clean, readable code that other developers can understand',
        'Test-driven development with comprehensive coverage',
        'RESTful API design following industry standards',
        'Database normalization and proper indexing',
        'Security best practices (OWASP Top 10)',
        'Performance optimization from day one',
        'Mobile-first responsive design',
        'Accessibility standards compliance'
    ];

    return (
        <div className={`min-h-screen ${isDarkMode ? 'bg-gray-950 text-gray-100' : 'bg-gray-50 text-gray-900'}`}>
            {/* Hero Section */}
            <section className={`relative overflow-hidden ${isDarkMode ? 'bg-gradient-to-br from-gray-900 via-gray-900 to-indigo-950' : 'bg-gradient-to-br from-white via-indigo-50 to-white'} border-b ${isDarkMode ? 'border-gray-800' : 'border-gray-200'}`}>
                <div className="absolute inset-0 opacity-10">
                    <div className="absolute top-0 left-1/4 w-96 h-96 bg-indigo-500 rounded-full blur-3xl"></div>
                    <div className="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full blur-3xl"></div>
                </div>
                <div className="relative max-w-6xl mx-auto px-6 py-20 md:py-28">
                    <div className="inline-flex items-center gap-2 text-xs uppercase tracking-widest text-indigo-500 font-semibold mb-6">
                        <span className="h-2 w-2 rounded-full bg-indigo-500 animate-pulse" />
                        Software Development Process
                    </div>
                    <h1 className="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight mb-6">
                        From <span className="bg-gradient-to-r from-indigo-500 to-purple-500 bg-clip-text text-transparent">Idea</span> to{' '}
                        <span className="bg-gradient-to-r from-purple-500 to-pink-500 bg-clip-text text-transparent">Production</span>
                    </h1>
                    <p className={`text-xl leading-relaxed max-w-3xl mb-8 ${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                        A complete guide to how software development works - from initial concept through deployment and ongoing maintenance. Learn the systematic process I follow to turn your ideas into production-ready applications.
                    </p>
                    <div className="flex flex-wrap gap-4">
                        <a
                            href="/contact"
                            className={`px-6 py-3 rounded-xl text-base font-semibold transition-all ${
                                isDarkMode ? 'bg-white text-gray-900 hover:bg-gray-100' : 'bg-gray-900 text-white hover:bg-gray-800'
                            } shadow-lg hover:shadow-xl`}
                        >
                            <i className="fas fa-paper-plane mr-2" />
                            Start Your Project
                        </a>
                        <a
                            href="/projects"
                            className={`px-6 py-3 rounded-xl text-base font-semibold border-2 transition-all ${
                                isDarkMode ? 'border-gray-700 text-gray-200 hover:border-gray-600' : 'border-gray-300 text-gray-700 hover:border-gray-400'
                            }`}
                        >
                            <i className="fas fa-folder-open mr-2" />
                            View Projects
                        </a>
                    </div>
                </div>
            </section>

            {/* Development Phases */}
            <section className="max-w-6xl mx-auto px-6 py-20">
                <div className="text-center mb-16">
                    <h2 className="text-3xl md:text-4xl font-bold mb-4">The 6 Phases of Software Development</h2>
                    <p className={`text-lg ${isDarkMode ? 'text-gray-400' : 'text-gray-600'} max-w-3xl mx-auto`}>
                        Every successful project follows a structured process. Here's how I transform your idea into a working product.
                    </p>
                </div>

                <div className="space-y-12">
                    {developmentPhases.map((phase, index) => (
                        <div
                            key={phase.phase}
                            className={`rounded-2xl border shadow-xl overflow-hidden ${
                                isDarkMode ? 'border-gray-800 bg-gray-900' : 'border-gray-200 bg-white'
                            }`}
                        >
                            <div className={`h-2 bg-gradient-to-r ${phase.color}`} />
                            <div className="p-8">
                                <div className="flex flex-col lg:flex-row gap-8">
                                    {/* Left: Phase Info */}
                                    <div className="lg:w-1/3">
                                        <div className={`inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br ${phase.color} text-white text-2xl mb-4 shadow-lg`}>
                                            <i className={phase.icon} />
                                        </div>
                                        <div className={`text-sm font-semibold mb-2 ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                                            {phase.phase}
                                        </div>
                                        <h3 className="text-2xl font-bold mb-3">{phase.title}</h3>
                                        <p className={`mb-4 ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                                            {phase.description}
                                        </p>
                                        <div className={`inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium ${
                                            isDarkMode ? 'bg-gray-800 text-gray-300' : 'bg-gray-100 text-gray-700'
                                        }`}>
                                            <i className="fas fa-clock" />
                                            {phase.duration}
                                        </div>
                                    </div>

                                    {/* Middle: Activities */}
                                    <div className="lg:w-1/3">
                                        <h4 className="font-bold mb-3 text-indigo-500">Key Activities</h4>
                                        <ul className="space-y-2">
                                            {phase.activities.map((activity, i) => (
                                                <li key={i} className={`flex items-start gap-2 text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                                                    <i className="fas fa-check text-green-500 mt-1 flex-shrink-0" />
                                                    <span>{activity}</span>
                                                </li>
                                            ))}
                                        </ul>
                                    </div>

                                    {/* Right: Deliverables */}
                                    <div className="lg:w-1/3">
                                        <h4 className="font-bold mb-3 text-purple-500">Deliverables</h4>
                                        <div className="space-y-2">
                                            {phase.deliverables.map((item, i) => (
                                                <div
                                                    key={i}
                                                    className={`px-3 py-2 rounded-lg text-sm ${
                                                        isDarkMode ? 'bg-gray-800 text-gray-300' : 'bg-gray-100 text-gray-700'
                                                    }`}
                                                >
                                                    <i className="fas fa-file-alt mr-2 text-indigo-500" />
                                                    {item}
                                                </div>
                                            ))}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </section>

            {/* Best Practices */}
            <section className={`py-20 ${isDarkMode ? 'bg-gray-900/50' : 'bg-gray-100/50'}`}>
                <div className="max-w-6xl mx-auto px-6">
                    <div className="text-center mb-12">
                        <h2 className="text-3xl md:text-4xl font-bold mb-4">Development Best Practices</h2>
                        <p className={`text-lg ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                            Industry standards I follow to ensure code quality and reliability
                        </p>
                    </div>
                    <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                        {bestPractices.map((practice) => (
                            <div
                                key={practice.title}
                                className={`rounded-xl border p-6 text-center ${isDarkMode ? 'border-gray-800 bg-gray-900' : 'border-gray-200 bg-white'}`}
                            >
                                <div className="mb-4 flex justify-center">
                                    <div className="h-14 w-14 rounded-full bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-2xl">
                                        <i className={practice.icon} />
                                    </div>
                                </div>
                                <h3 className="font-bold mb-2">{practice.title}</h3>
                                <p className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                                    {practice.description}
                                </p>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Technical Stack */}
            <section className="max-w-6xl mx-auto px-6 py-20">
                <div className="text-center mb-12">
                    <h2 className="text-3xl md:text-4xl font-bold mb-4">Technologies I Use</h2>
                    <p className={`text-lg ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                        Modern, proven technologies for building scalable applications
                    </p>
                </div>
                <div className="grid gap-6 md:grid-cols-2">
                    {technicalStack.map((stack) => (
                        <div
                            key={stack.category}
                            className={`rounded-xl border p-6 ${isDarkMode ? 'border-gray-800 bg-gray-900' : 'border-gray-200 bg-white'}`}
                        >
                            <div className="flex items-center gap-3 mb-4">
                                <div className="h-12 w-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 text-white flex items-center justify-center">
                                    <i className={stack.icon} />
                                </div>
                                <h3 className="text-xl font-bold">{stack.category}</h3>
                            </div>
                            <div className="flex flex-wrap gap-2">
                                {stack.technologies.map((tech) => (
                                    <span
                                        key={tech}
                                        className={`px-3 py-1.5 rounded-lg text-sm font-medium ${
                                            isDarkMode ? 'bg-gray-800 text-gray-300' : 'bg-gray-100 text-gray-700'
                                        }`}
                                    >
                                        {tech}
                                    </span>
                                ))}
                            </div>
                        </div>
                    ))}
                </div>
            </section>

            {/* Development Principles */}
            <section className={`py-20 ${isDarkMode ? 'bg-gray-900/50' : 'bg-gray-100/50'}`}>
                <div className="max-w-6xl mx-auto px-6">
                    <div className="text-center mb-12">
                        <h2 className="text-3xl md:text-4xl font-bold mb-4">My Development Principles</h2>
                        <p className={`text-lg ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                            Core principles that guide every line of code I write
                        </p>
                    </div>
                    <div className="grid gap-4 md:grid-cols-2">
                        {developmentPrinciples.map((principle, index) => (
                            <div
                                key={index}
                                className={`rounded-xl border p-4 flex items-start gap-3 ${
                                    isDarkMode ? 'border-gray-800 bg-gray-900' : 'border-gray-200 bg-white'
                                }`}
                            >
                                <div className="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                                    {index + 1}
                                </div>
                                <p className={isDarkMode ? 'text-gray-300' : 'text-gray-700'}>{principle}</p>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className="max-w-6xl mx-auto px-6 py-20">
                <div className={`rounded-2xl border p-12 text-center ${isDarkMode ? 'border-gray-800 bg-gradient-to-br from-gray-900 to-indigo-950' : 'border-gray-200 bg-gradient-to-br from-indigo-50 to-purple-50'}`}>
                    <h2 className="text-3xl md:text-4xl font-bold mb-4">Ready to Start Your Software Project?</h2>
                    <p className={`text-lg ${isDarkMode ? 'text-gray-300' : 'text-gray-600'} mb-8 max-w-2xl mx-auto`}>
                        Let's discuss your idea and create a clear roadmap from concept to production. I'll guide you through every phase of development.
                    </p>
                    <div className="flex flex-wrap gap-4 justify-center">
                        <a
                            href="/contact"
                            className={`px-8 py-4 rounded-xl text-base font-semibold transition-all ${
                                isDarkMode ? 'bg-white text-gray-900 hover:bg-gray-100' : 'bg-gray-900 text-white hover:bg-gray-800'
                            } shadow-lg hover:shadow-xl`}
                        >
                            <i className="fas fa-paper-plane mr-2" />
                            Start Your Project
                        </a>
                        <a
                            href="/case-studies"
                            className={`px-8 py-4 rounded-xl text-base font-semibold border-2 transition-all ${
                                isDarkMode ? 'border-gray-700 text-gray-200 hover:border-gray-600' : 'border-gray-300 text-gray-700 hover:border-gray-400'
                            }`}
                        >
                            <i className="fas fa-book-open mr-2" />
                            View Case Studies
                        </a>
                    </div>
                </div>
            </section>
        </div>
    );
};

export default SoftwareEngineer;
