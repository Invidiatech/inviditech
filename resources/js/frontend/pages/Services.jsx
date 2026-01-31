import React, { useState } from 'react';

const Services = ({ isDarkMode }) => {
    const [activeService, setActiveService] = useState(0);

    const services = [
        {
            title: 'Laravel Development',
            description: 'Build robust, scalable web applications with Laravel. From custom business logic to complex enterprise solutions.',
            icon: 'fab fa-laravel',
            iconBg: 'from-red-500 to-orange-500',
            features: [
                'Custom Web Applications',
                'RESTful API Development',
                'Database Design & Optimization',
                'Third-party Integrations',
                'Authentication & Authorization',
                'Real-time Features'
            ],
            technologies: ['Laravel', 'PHP', 'MySQL', 'Redis', 'Livewire'],
            href: '/services/laravel-development'
        },
        {
            title: 'API Development',
            description: 'Create secure, scalable REST APIs that power mobile apps, integrations, and microservices.',
            icon: 'fas fa-plug',
            iconBg: 'from-blue-500 to-cyan-500',
            features: [
                'RESTful API Design',
                'OAuth2 & JWT Authentication',
                'API Rate Limiting',
                'Comprehensive Documentation',
                'Versioning Strategy',
                'Webhook Integration'
            ],
            technologies: ['REST', 'OAuth2', 'Postman', 'Swagger', 'JWT'],
            href: '/services/api-development'
        },
        {
            title: 'Performance Optimization',
            description: 'Supercharge your application\'s speed and efficiency with expert optimization techniques.',
            icon: 'fas fa-rocket',
            iconBg: 'from-green-500 to-emerald-500',
            features: [
                'Database Query Optimization',
                'Caching Strategies (Redis)',
                'Code Profiling & Analysis',
                'Infrastructure Scaling',
                'Load Testing & Monitoring',
                'CDN Integration'
            ],
            technologies: ['Redis', 'Memcached', 'New Relic', 'CloudFlare', 'AWS'],
            href: '/services/performance-optimization'
        },
        {
            title: 'Code Review & Audits',
            description: 'Get expert insights into your codebase with comprehensive reviews and security audits.',
            icon: 'fas fa-shield-alt',
            iconBg: 'from-purple-500 to-pink-500',
            features: [
                'Security Vulnerability Assessment',
                'Code Quality Analysis',
                'Best Practices Review',
                'Architecture Evaluation',
                'Performance Bottlenecks',
                'Refactoring Recommendations'
            ],
            technologies: ['SonarQube', 'PHPStan', 'PHPCS', 'ESLint', 'Security Tools'],
            href: '/contact'
        },
        {
            title: 'Admin Dashboards',
            description: 'Beautiful, functional admin panels with role-based access and real-time analytics.',
            icon: 'fas fa-chart-line',
            iconBg: 'from-indigo-500 to-purple-500',
            features: [
                'Role-Based Access Control',
                'Real-time Analytics',
                'Custom Modules & Widgets',
                'Responsive Design',
                'Data Export & Reporting',
                'Activity Logging'
            ],
            technologies: ['Laravel Nova', 'React', 'Tailwind', 'Chart.js', 'Livewire'],
            href: '/contact'
        },
        {
            title: 'SEO Optimization',
            description: 'Boost your organic visibility with technical SEO, structured data, and performance optimization.',
            icon: 'fas fa-search',
            iconBg: 'from-yellow-500 to-orange-500',
            features: [
                'Technical SEO Audit',
                'Schema.org Markup',
                'Meta Tag Optimization',
                'Sitemap Generation',
                'Page Speed Optimization',
                'Mobile-First Design'
            ],
            technologies: ['Schema.org', 'Google Analytics', 'Search Console', 'Lighthouse', 'SEMrush'],
            href: '/contact'
        }
    ];

    const stats = [
        { number: '50+', label: 'Projects Delivered', icon: 'fas fa-briefcase' },
        { number: '30+', label: 'Happy Clients', icon: 'fas fa-smile' },
        { number: '99.9%', label: 'Uptime Rate', icon: 'fas fa-server' },
        { number: '24/7', label: 'Support Available', icon: 'fas fa-headset' }
    ];

    return (
        <div className={`min-h-screen ${isDarkMode ? 'bg-gray-950' : 'bg-gray-50'}`}>
            {/* Hero Section */}
            <section className={`relative overflow-hidden ${isDarkMode ? 'bg-gradient-to-br from-gray-900 via-indigo-950 to-gray-900' : 'bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-800'}`}>
                {/* Animated Background */}
                <div className="absolute inset-0 opacity-20">
                    <div className="absolute top-0 left-1/4 w-96 h-96 bg-purple-500 rounded-full blur-3xl animate-blob"></div>
                    <div className="absolute top-0 right-1/4 w-96 h-96 bg-indigo-500 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
                    <div className="absolute bottom-0 left-1/3 w-96 h-96 bg-pink-500 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
                </div>

                <div className="relative max-w-7xl mx-auto px-6 py-24 md:py-32">
                    <div className="text-center max-w-4xl mx-auto">
                        <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-lg border border-white/20 mb-8">
                            <span className="relative flex h-3 w-3">
                                <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                <span className="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                            </span>
                            <span className="text-white text-sm font-semibold">Professional Services</span>
                        </div>
                        
                        <h1 className="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
                            Transform Your
                            <span className="block bg-gradient-to-r from-yellow-300 via-pink-300 to-purple-300 bg-clip-text text-transparent">
                                Digital Vision
                            </span>
                        </h1>
                        
                        <p className="text-xl md:text-2xl text-indigo-100 mb-10 leading-relaxed">
                            Expert Laravel development, API design, and performance optimization 
                            to power your business forward.
                        </p>

                        <div className="flex flex-wrap gap-4 justify-center">
                            <a
                                href="/contact"
                                className="group px-8 py-4 bg-white text-indigo-600 rounded-xl font-bold shadow-2xl hover:shadow-white/20 transform hover:scale-105 transition-all duration-300 inline-flex items-center gap-2"
                            >
                                Start Your Project
                                <i className="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            <a
                                href="#services"
                                className="px-8 py-4 bg-white/10 backdrop-blur-lg text-white border-2 border-white/30 rounded-xl font-bold hover:bg-white/20 transform hover:scale-105 transition-all duration-300"
                            >
                                Explore Services
                            </a>
                        </div>
                    </div>
                </div>

                {/* Wave Divider */}
                <div className="absolute bottom-0 left-0 right-0">
                    <svg className="w-full h-auto" viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" 
                              fill={isDarkMode ? '#030712' : '#f9fafb'}/>
                    </svg>
                </div>
            </section>

            {/* Stats Section */}
            <section className="py-16">
                <div className="max-w-7xl mx-auto px-6">
                    <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
                        {stats.map((stat, index) => (
                            <div key={index} className={`text-center p-6 rounded-2xl ${isDarkMode ? 'bg-gray-900 border border-gray-800' : 'bg-white border border-gray-200'} shadow-xl transform hover:scale-105 transition-all duration-300`}>
                                <div className={`w-12 h-12 mx-auto mb-4 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center ${isDarkMode ? 'shadow-indigo-500/50' : 'shadow-indigo-500/30'} shadow-lg`}>
                                    <i className={`${stat.icon} text-white text-lg`}></i>
                                </div>
                                <div className="text-3xl md:text-4xl font-bold bg-gradient-to-r from-indigo-500 to-purple-600 bg-clip-text text-transparent mb-2">
                                    {stat.number}
                                </div>
                                <div className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                                    {stat.label}
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Services Grid */}
            <section id="services" className="py-20">
                <div className="max-w-7xl mx-auto px-6">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-4 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                            Our <span className="bg-gradient-to-r from-indigo-500 to-purple-600 bg-clip-text text-transparent">Services</span>
                        </h2>
                        <p className={`text-xl ${isDarkMode ? 'text-gray-400' : 'text-gray-600'} max-w-3xl mx-auto`}>
                            Comprehensive solutions tailored to your business needs
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {services.map((service, index) => (
                            <div
                                key={index}
                                onMouseEnter={() => setActiveService(index)}
                                className={`group relative rounded-2xl overflow-hidden transition-all duration-300 transform hover:scale-105 ${
                                    isDarkMode ? 'bg-gray-900 border border-gray-800' : 'bg-white border border-gray-200'
                                } shadow-xl hover:shadow-2xl`}
                            >
                                {/* Gradient Top Border */}
                                <div className={`h-1 bg-gradient-to-r ${service.iconBg}`}></div>
                                
                                <div className="p-8">
                                    {/* Icon */}
                                    <div className={`w-16 h-16 mb-6 rounded-2xl bg-gradient-to-br ${service.iconBg} flex items-center justify-center shadow-lg transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300`}>
                                        <i className={`${service.icon} text-3xl text-white`}></i>
                                    </div>

                                    {/* Title & Description */}
                                    <h3 className={`text-2xl font-bold mb-3 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                        {service.title}
                                    </h3>
                                    <p className={`mb-6 ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                                        {service.description}
                                    </p>

                                    {/* Features */}
                                    <ul className="space-y-2 mb-6">
                                        {service.features.map((feature, featureIndex) => (
                                            <li key={featureIndex} className={`flex items-start text-sm ${isDarkMode ? 'text-gray-300' : 'text-gray-700'}`}>
                                                <i className="fas fa-check-circle text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                                                <span>{feature}</span>
                                            </li>
                                        ))}
                                    </ul>

                                    {/* Technologies */}
                                    <div className="flex flex-wrap gap-2 mb-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                        {service.technologies.slice(0, 3).map((tech, techIndex) => (
                                            <span
                                                key={techIndex}
                                                className={`px-3 py-1 rounded-lg text-xs font-medium ${
                                                    isDarkMode ? 'bg-gray-800 text-gray-300' : 'bg-gray-100 text-gray-700'
                                                }`}
                                            >
                                                {tech}
                                            </span>
                                        ))}
                                        {service.technologies.length > 3 && (
                                            <span className={`px-3 py-1 rounded-lg text-xs font-medium ${isDarkMode ? 'bg-gray-800 text-gray-400' : 'bg-gray-100 text-gray-500'}`}>
                                                +{service.technologies.length - 3} more
                                            </span>
                                        )}
                                    </div>

                                    {/* Learn More Link */}
                                    <a
                                        href={service.href}
                                        className="inline-flex items-center gap-2 font-semibold text-indigo-600 hover:text-indigo-500 group-hover:gap-3 transition-all"
                                    >
                                        Learn More
                                        <i className="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Process Section */}
            <section className={`py-20 ${isDarkMode ? 'bg-gray-900/50' : 'bg-gray-100'}`}>
                <div className="max-w-7xl mx-auto px-6">
                    <div className="text-center mb-16">
                        <h2 className={`text-4xl md:text-5xl font-bold mb-4 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                            How We <span className="bg-gradient-to-r from-indigo-500 to-purple-600 bg-clip-text text-transparent">Work</span>
                        </h2>
                        <p className={`text-xl ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                            Our proven process for delivering exceptional results
                        </p>
                    </div>

                    <div className="grid md:grid-cols-4 gap-8">
                        {[
                            { step: '01', title: 'Discovery', description: 'We understand your needs, goals, and challenges', icon: 'fas fa-search' },
                            { step: '02', title: 'Planning', description: 'Strategic roadmap with clear milestones', icon: 'fas fa-map' },
                            { step: '03', title: 'Development', description: 'Agile development with regular updates', icon: 'fas fa-code' },
                            { step: '04', title: 'Delivery', description: 'Launch, support, and continuous improvement', icon: 'fas fa-rocket' }
                        ].map((process, index) => (
                            <div key={index} className="text-center">
                                <div className={`relative w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center ${isDarkMode ? 'shadow-indigo-500/50' : 'shadow-indigo-500/30'} shadow-2xl transform hover:scale-110 transition-all duration-300`}>
                                    <i className={`${process.icon} text-2xl text-white`}></i>
                                    <span className="absolute -top-2 -right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center text-xs font-bold text-indigo-600 shadow-lg">
                                        {process.step}
                                    </span>
                                </div>
                                <h3 className={`text-xl font-bold mb-2 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                    {process.title}
                                </h3>
                                <p className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                                    {process.description}
                                </p>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className="py-20">
                <div className="max-w-4xl mx-auto px-6">
                    <div className={`relative rounded-3xl overflow-hidden ${isDarkMode ? 'bg-gradient-to-br from-gray-900 to-indigo-950' : 'bg-gradient-to-br from-indigo-600 to-purple-600'} p-12 md:p-16 text-center shadow-2xl`}>
                        {/* Background Pattern */}
                        <div className="absolute inset-0 opacity-10">
                            <div className="absolute top-0 right-0 w-64 h-64 bg-white rounded-full blur-3xl"></div>
                            <div className="absolute bottom-0 left-0 w-64 h-64 bg-white rounded-full blur-3xl"></div>
                        </div>

                        <div className="relative z-10">
                            <h2 className="text-4xl md:text-5xl font-bold text-white mb-6">
                                Ready to Start Your Project?
                            </h2>
                            <p className="text-xl text-indigo-100 mb-10 max-w-2xl mx-auto">
                                Let's discuss how we can help transform your ideas into reality with cutting-edge technology.
                            </p>
                            <div className="flex flex-wrap gap-4 justify-center">
                                <a
                                    href="/contact"
                                    className="group px-8 py-4 bg-white text-indigo-600 rounded-xl font-bold shadow-2xl hover:shadow-white/20 transform hover:scale-105 transition-all duration-300 inline-flex items-center gap-2"
                                >
                                    Get Started Today
                                    <i className="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </a>
                                <a
                                    href="/case-studies"
                                    className="px-8 py-4 bg-white/10 backdrop-blur-lg text-white border-2 border-white/30 rounded-xl font-bold hover:bg-white/20 transform hover:scale-105 transition-all duration-300 inline-flex items-center gap-2"
                                >
                                    View Case Studies
                                    <i className="fas fa-book-open"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Custom Animations */}
            <style>{`
                @keyframes blob {
                    0%, 100% { transform: translate(0, 0) scale(1); }
                    25% { transform: translate(20px, -50px) scale(1.1); }
                    50% { transform: translate(-20px, 20px) scale(0.9); }
                    75% { transform: translate(50px, 50px) scale(1.05); }
                }
                
                .animate-blob {
                    animation: blob 7s infinite;
                }
                
                .animation-delay-2000 {
                    animation-delay: 2s;
                }
                
                .animation-delay-4000 {
                    animation-delay: 4s;
                }
            `}</style>
        </div>
    );
};

export default Services;
