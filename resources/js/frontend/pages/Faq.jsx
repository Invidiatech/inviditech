import React, { useState } from 'react';

const Faq = ({ isDarkMode }) => {
    const [searchTerm, setSearchTerm] = useState('');
    const [activeCategory, setActiveCategory] = useState('all');

    const faqCategories = [
        {
            name: 'General',
            icon: 'fas fa-info-circle',
            questions: [
                {
                    q: 'What services do you offer?',
                    a: 'We specialize in Laravel development, API engineering, performance optimization, custom web applications, SaaS platform development, e-commerce solutions, and database design. We also provide consulting on architecture, security, and scaling strategies.'
                },
                {
                    q: 'What industries do you work with?',
                    a: 'We work across diverse industries including e-commerce, SaaS, healthcare, education, finance, logistics, and media. Our experience spans B2B and B2C applications, internal tools, and customer-facing platforms.'
                },
                {
                    q: 'Do you work with startups or established companies?',
                    a: 'Both! We help startups build MVPs and launch quickly, and we support established companies with modernization, scaling, and feature development. Our approach adapts to your stage and needs.'
                },
                {
                    q: 'What is your tech stack?',
                    a: 'Our primary stack includes Laravel (PHP), React, Vue.js, PostgreSQL, MySQL, Redis, Docker, and AWS. We choose technologies based on your project requirements and can work with existing tech stacks.'
                }
            ]
        },
        {
            name: 'Process',
            icon: 'fas fa-tasks',
            questions: [
                {
                    q: 'How do we start a project?',
                    a: 'Start by sharing your goals, timeline, and any technical details through our contact form or email. We\'ll schedule a discovery call to understand your needs, then provide a detailed proposal with timeline, scope, and pricing. Once approved, we kick off with a planning session.'
                },
                {
                    q: 'What is your development process?',
                    a: 'We follow an agile methodology with 2-week sprints. Each sprint includes planning, development, testing, and review. You\'ll have access to a staging environment to see progress in real-time, and we conduct weekly status meetings to keep you informed.'
                },
                {
                    q: 'How do you handle project management?',
                    a: 'We use tools like Jira, Trello, or your preferred platform for task tracking. You\'ll have full visibility into progress, timelines, and any blockers. We assign a dedicated project lead who serves as your main point of contact.'
                },
                {
                    q: 'What is your typical project timeline?',
                    a: 'It varies by scope. Small projects take 4-6 weeks, medium projects 2-3 months, and large platforms 4-6 months. We provide detailed timelines during the proposal phase and adjust as needed based on changing requirements.'
                }
            ]
        },
        {
            name: 'Technical',
            icon: 'fas fa-code',
            questions: [
                {
                    q: 'Do you write tests for the code?',
                    a: 'Yes, absolutely. We write unit tests, integration tests, and end-to-end tests as part of our standard practice. Our code coverage typically exceeds 80%, and all tests run automatically in our CI/CD pipeline before deployment.'
                },
                {
                    q: 'How do you ensure code quality?',
                    a: 'We follow PSR standards for PHP, use ESLint for JavaScript, conduct peer code reviews, run automated testing, use static analysis tools (PHPStan, Psalm), and maintain comprehensive documentation. All code is version controlled with Git.'
                },
                {
                    q: 'Can you work with our existing codebase?',
                    a: 'Yes. We regularly work with legacy codebases, conducting audits, refactoring, and adding new features. We can also help migrate from older frameworks to modern stacks while maintaining business continuity.'
                },
                {
                    q: 'How do you handle database optimization?',
                    a: 'We use proper indexing, query optimization, database caching with Redis, efficient ORM usage, database monitoring tools, and regular performance audits. We also implement strategies like read replicas and connection pooling for high-traffic applications.'
                }
            ]
        },
        {
            name: 'Pricing & Support',
            icon: 'fas fa-dollar-sign',
            questions: [
                {
                    q: 'How do you price projects?',
                    a: 'We offer fixed-price projects for well-defined scopes and hourly/monthly retainers for ongoing work. After understanding your requirements, we provide a detailed proposal with transparent pricing, deliverables, and payment milestones.'
                },
                {
                    q: 'Do you provide ongoing support?',
                    a: 'Yes. We offer post-launch support including bug fixes, monitoring, security updates, performance optimization, and feature enhancements. Support packages can be hourly, monthly retainer, or SLA-based depending on your needs.'
                },
                {
                    q: 'What happens after the project launches?',
                    a: 'We provide a warranty period (typically 30-90 days) to fix any bugs. We also offer training for your team, comprehensive documentation, deployment guides, and optional ongoing maintenance packages.'
                },
                {
                    q: 'Do you offer hosting services?',
                    a: 'We don\'t provide hosting directly, but we help you set up and configure hosting on platforms like AWS, DigitalOcean, or your preferred provider. We can also manage your infrastructure as part of a DevOps retainer.'
                }
            ]
        },
        {
            name: 'Collaboration',
            icon: 'fas fa-users',
            questions: [
                {
                    q: 'Can you work with our existing team?',
                    a: 'Absolutely. We integrate seamlessly with your in-house developers, designers, and product managers. We can work as an extension of your team, lead development, or provide specialized expertise for specific features.'
                },
                {
                    q: 'What time zones do you work in?',
                    a: 'We\'re flexible with time zones and have successfully worked with clients across North America, Europe, Asia, and Australia. We schedule meetings at mutually convenient times and ensure overlap hours for real-time collaboration.'
                },
                {
                    q: 'How do you communicate during projects?',
                    a: 'We use your preferred communication tools (Slack, Microsoft Teams, Email). We provide weekly status reports, conduct sprint reviews, and are available for ad-hoc calls. You\'ll always know what we\'re working on and what\'s coming next.'
                },
                {
                    q: 'Do you sign NDAs and other legal agreements?',
                    a: 'Yes, we routinely sign NDAs, service agreements, and other legal documents. We respect confidentiality and can work within your existing legal frameworks and compliance requirements.'
                }
            ]
        },
        {
            name: 'Security & Compliance',
            icon: 'fas fa-shield-alt',
            questions: [
                {
                    q: 'How do you handle security?',
                    a: 'We follow OWASP Top 10 guidelines, implement proper authentication and authorization, use encrypted connections (HTTPS, SSL/TLS), conduct security audits, sanitize all inputs, and keep dependencies updated with security patches.'
                },
                {
                    q: 'Can you help with GDPR or CCPA compliance?',
                    a: 'Yes. We implement data protection features including consent management, data encryption, user data export/deletion, audit logs, and privacy policy integrations. We\'ll work with your legal team to ensure compliance.'
                },
                {
                    q: 'How do you protect sensitive data?',
                    a: 'We use encryption at rest and in transit, implement role-based access control, follow the principle of least privilege, use environment variables for secrets, conduct regular security audits, and never commit sensitive data to version control.'
                },
                {
                    q: 'What is your backup and disaster recovery strategy?',
                    a: 'We implement automated daily backups, test restore procedures regularly, use redundant systems, implement monitoring and alerting, document recovery procedures, and can help you achieve your desired RTO and RPO targets.'
                }
            ]
        }
    ];

    const allQuestions = faqCategories.flatMap(cat => 
        cat.questions.map(q => ({ ...q, category: cat.name, icon: cat.icon }))
    );

    const filteredQuestions = allQuestions.filter(item => {
        const matchesSearch = searchTerm === '' || 
            item.q.toLowerCase().includes(searchTerm.toLowerCase()) ||
            item.a.toLowerCase().includes(searchTerm.toLowerCase());
        const matchesCategory = activeCategory === 'all' || item.category === activeCategory;
        return matchesSearch && matchesCategory;
    });

    return (
        <div className={`min-h-screen ${isDarkMode ? 'bg-gray-950 text-gray-100' : 'bg-gray-50 text-gray-900'}`}>
            {/* Hero Section */}
            <section className={`relative overflow-hidden ${isDarkMode ? 'bg-gradient-to-br from-gray-900 via-gray-900 to-blue-950' : 'bg-gradient-to-br from-white via-blue-50 to-white'} border-b ${isDarkMode ? 'border-gray-800' : 'border-gray-200'}`}>
                <div className="absolute inset-0 opacity-10">
                    <div className="absolute top-0 right-1/4 w-96 h-96 bg-blue-500 rounded-full blur-3xl"></div>
                    <div className="absolute bottom-0 left-1/4 w-96 h-96 bg-indigo-500 rounded-full blur-3xl"></div>
                </div>
                <div className="relative max-w-6xl mx-auto px-6 py-20 md:py-28">
                    <div className="text-center">
                        <div className="inline-flex items-center gap-2 text-xs uppercase tracking-widest text-indigo-500 font-semibold mb-6">
                            <span className="h-2 w-2 rounded-full bg-indigo-500 animate-pulse" />
                            Frequently Asked Questions
                        </div>
                        <h1 className="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight mb-6">
                            Got <span className="bg-gradient-to-r from-blue-500 to-indigo-500 bg-clip-text text-transparent">Questions?</span>
                        </h1>
                        <p className={`text-xl leading-relaxed max-w-3xl mx-auto ${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                            Find clear, detailed answers to common questions about our services, process, pricing, and how we work with clients.
                        </p>

                        {/* Search Bar */}
                        <div className="mt-10 max-w-2xl mx-auto">
                            <div className={`relative rounded-xl border-2 ${isDarkMode ? 'border-gray-800 bg-gray-900' : 'border-gray-200 bg-white'} shadow-lg`}>
                                <i className={`fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 ${isDarkMode ? 'text-gray-500' : 'text-gray-400'}`} />
                                <input
                                    type="text"
                                    placeholder="Search questions..."
                                    value={searchTerm}
                                    onChange={(e) => setSearchTerm(e.target.value)}
                                    className={`w-full pl-12 pr-4 py-4 rounded-xl text-lg ${
                                        isDarkMode ? 'bg-transparent text-gray-100 placeholder-gray-500' : 'bg-transparent text-gray-900 placeholder-gray-400'
                                    } focus:outline-none`}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Category Filters */}
            <section className="max-w-6xl mx-auto px-6 py-8 sticky top-0 z-10 backdrop-blur-lg">
                <div className={`rounded-xl border p-4 ${isDarkMode ? 'bg-gray-900/90 border-gray-800' : 'bg-white/90 border-gray-200'} shadow-lg`}>
                    <div className="flex flex-wrap gap-3">
                        <button
                            onClick={() => setActiveCategory('all')}
                            className={`px-4 py-2 rounded-lg text-sm font-medium transition-all flex items-center gap-2 ${
                                activeCategory === 'all'
                                    ? 'bg-gradient-to-r from-indigo-500 to-blue-500 text-white shadow-lg'
                                    : isDarkMode 
                                        ? 'bg-gray-800 text-gray-300 hover:bg-gray-700' 
                                        : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                            }`}
                        >
                            <i className="fas fa-th" />
                            All
                        </button>
                        {faqCategories.map((cat) => (
                            <button
                                key={cat.name}
                                onClick={() => setActiveCategory(cat.name)}
                                className={`px-4 py-2 rounded-lg text-sm font-medium transition-all flex items-center gap-2 ${
                                    activeCategory === cat.name
                                        ? 'bg-gradient-to-r from-indigo-500 to-blue-500 text-white shadow-lg'
                                        : isDarkMode 
                                            ? 'bg-gray-800 text-gray-300 hover:bg-gray-700' 
                                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                                }`}
                            >
                                <i className={cat.icon} />
                                {cat.name}
                            </button>
                        ))}
                    </div>
                </div>
            </section>

            {/* FAQ Items */}
            <section className="max-w-6xl mx-auto px-6 py-12">
                {filteredQuestions.length === 0 ? (
                    <div className="text-center py-20">
                        <i className={`fas fa-search text-6xl mb-4 ${isDarkMode ? 'text-gray-700' : 'text-gray-300'}`} />
                        <h3 className="text-2xl font-bold mb-2">No questions found</h3>
                        <p className={isDarkMode ? 'text-gray-400' : 'text-gray-600'}>Try a different search term or category</p>
                    </div>
                ) : (
                    <div className="grid gap-4">
                        {filteredQuestions.map((item, index) => (
                            <details
                                key={index}
                                className={`group rounded-2xl border shadow-lg hover:shadow-xl transition-all duration-300 ${
                                    isDarkMode ? 'border-gray-800 bg-gray-900' : 'border-gray-200 bg-white'
                                }`}
                            >
                                <summary className="cursor-pointer p-6 flex items-start justify-between">
                                    <div className="flex items-start gap-4 flex-1">
                                        <div className={`h-10 w-10 rounded-lg flex items-center justify-center flex-shrink-0 ${
                                            isDarkMode ? 'bg-indigo-500/10 text-indigo-400' : 'bg-indigo-100 text-indigo-600'
                                        }`}>
                                            <i className={item.icon} />
                                        </div>
                                        <div>
                                            <span className={`inline-block px-2 py-1 rounded text-xs font-semibold mb-2 ${
                                                isDarkMode ? 'bg-gray-800 text-gray-400' : 'bg-gray-100 text-gray-600'
                                            }`}>
                                                {item.category}
                                            </span>
                                            <h3 className="text-lg font-bold">{item.q}</h3>
                                        </div>
                                    </div>
                                    <span className="text-indigo-500 group-open:rotate-180 transition-transform ml-4 flex-shrink-0">
                                        <i className="fas fa-chevron-down text-xl" />
                                    </span>
                                </summary>
                                <div className={`px-6 pb-6 pl-20 ${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                                    {item.a}
                                </div>
                            </details>
                        ))}
                    </div>
                )}
            </section>

            {/* Quick Stats */}
            <section className={`py-16 ${isDarkMode ? 'bg-gray-900/50' : 'bg-gray-100/50'}`}>
                <div className="max-w-6xl mx-auto px-6">
                    <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div className="text-center">
                            <div className="text-4xl font-bold text-indigo-500 mb-2">24/7</div>
                            <div className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>Support Available</div>
                        </div>
                        <div className="text-center">
                            <div className="text-4xl font-bold text-blue-500 mb-2">2-4h</div>
                            <div className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>Response Time</div>
                        </div>
                        <div className="text-center">
                            <div className="text-4xl font-bold text-green-500 mb-2">95%</div>
                            <div className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>Client Satisfaction</div>
                        </div>
                        <div className="text-center">
                            <div className="text-4xl font-bold text-purple-500 mb-2">10+</div>
                            <div className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>Years Experience</div>
                        </div>
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className="max-w-6xl mx-auto px-6 py-20">
                <div className={`rounded-2xl border p-12 text-center ${isDarkMode ? 'border-gray-800 bg-gradient-to-br from-gray-900 to-blue-950' : 'border-gray-200 bg-gradient-to-br from-blue-50 to-indigo-50'}`}>
                    <div className="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-500 text-white text-2xl mb-6 shadow-lg">
                        <i className="fas fa-comments" />
                    </div>
                    <h2 className="text-3xl md:text-4xl font-bold mb-4">Still Have Questions?</h2>
                    <p className={`text-lg ${isDarkMode ? 'text-gray-300' : 'text-gray-600'} mb-8 max-w-2xl mx-auto`}>
                        Can't find the answer you're looking for? Get in touch with us and we'll be happy to help.
                    </p>
                    <div className="flex flex-wrap gap-4 justify-center">
                        <a
                            href="/contact"
                            className={`px-8 py-4 rounded-xl text-base font-semibold transition-all ${
                                isDarkMode ? 'bg-white text-gray-900 hover:bg-gray-100' : 'bg-gray-900 text-white hover:bg-gray-800'
                            } shadow-lg hover:shadow-xl`}
                        >
                            Contact Us
                        </a>
                        <a
                            href="/services"
                            className={`px-8 py-4 rounded-xl text-base font-semibold border-2 transition-all ${
                                isDarkMode ? 'border-gray-700 text-gray-200 hover:border-gray-600' : 'border-gray-300 text-gray-700 hover:border-gray-400'
                            }`}
                        >
                            View Services
                        </a>
                    </div>
                </div>
            </section>
        </div>
    );
};

export default Faq;
