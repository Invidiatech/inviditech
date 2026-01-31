import React from 'react';

const ServicesPerformance = ({ isDarkMode }) => {
    const optimizationAreas = [
        {
            title: 'Database Query Optimization',
            description: 'Optimize slow queries, add proper indexes, and eliminate N+1 problems',
            techniques: ['Query profiling', 'Index optimization', 'Query caching', 'Connection pooling'],
            icon: 'fas fa-database',
            impact: 'Up to 80% faster queries'
        },
        {
            title: 'Caching Strategies',
            description: 'Implement Redis, Memcached, and application-level caching',
            techniques: ['Redis caching', 'CDN integration', 'Browser caching', 'Cache invalidation'],
            icon: 'fas fa-bolt',
            impact: '60-70% load reduction'
        },
        {
            title: 'Code Optimization',
            description: 'Refactor inefficient code and optimize algorithms',
            techniques: ['Code profiling', 'Lazy loading', 'Asset optimization', 'API response compression'],
            icon: 'fas fa-code',
            impact: '40-50% faster execution'
        },
        {
            title: 'Infrastructure Tuning',
            description: 'Optimize server configuration and resource allocation',
            techniques: ['PHP-FPM tuning', 'Nginx optimization', 'Queue workers', 'Load balancing'],
            icon: 'fas fa-server',
            impact: 'Better resource usage'
        }
    ];

    const performanceMetrics = [
        {
            metric: 'Page Load Time',
            before: '3-5 seconds',
            after: '<1 second',
            icon: 'fas fa-clock'
        },
        {
            metric: 'API Response',
            before: '500-1000ms',
            after: '<200ms',
            icon: 'fas fa-tachometer-alt'
        },
        {
            metric: 'Database Queries',
            before: '50-100+ queries',
            after: '<20 queries',
            icon: 'fas fa-database'
        },
        {
            metric: 'Server Load',
            before: 'High CPU usage',
            after: '40-60% reduction',
            icon: 'fas fa-chart-line'
        }
    ];

    const optimizationProcess = [
        {
            step: 1,
            title: 'Performance Audit',
            description: 'Analyze current performance using profiling tools to identify bottlenecks',
            tools: ['New Relic', 'Blackfire', 'Laravel Debugbar']
        },
        {
            step: 2,
            title: 'Bottleneck Analysis',
            description: 'Identify slow queries, memory leaks, and inefficient code patterns',
            tools: ['Query logs', 'APM tools', 'Performance monitoring']
        },
        {
            step: 3,
            title: 'Optimization Implementation',
            description: 'Apply caching, query optimization, and code refactoring',
            tools: ['Redis', 'Database indexes', 'Code refactoring']
        },
        {
            step: 4,
            title: 'Testing & Monitoring',
            description: 'Load testing, benchmarking, and continuous performance monitoring',
            tools: ['Load testing', 'Performance tracking', 'Alerts']
        }
    ];

    const commonIssues = [
        {
            issue: 'N+1 Query Problem',
            solution: 'Use eager loading with Laravel relationships',
            example: 'Replace 100 queries with 2 queries using eager loading'
        },
        {
            issue: 'Missing Database Indexes',
            solution: 'Add indexes on frequently queried columns',
            example: 'Query time reduced from 2s to 50ms with proper indexing'
        },
        {
            issue: 'No Caching Layer',
            solution: 'Implement Redis caching for frequently accessed data',
            example: 'API response time improved by 70% with caching'
        },
        {
            issue: 'Large Payload Sizes',
            solution: 'Implement API pagination and response compression',
            example: 'Reduced payload from 5MB to 200KB with pagination'
        },
        {
            issue: 'Blocking Operations',
            solution: 'Move heavy tasks to background jobs with queues',
            example: 'Email sending moved to queues, instant API responses'
        },
        {
            issue: 'Inefficient Queries',
            solution: 'Optimize JOIN queries and use database views',
            example: 'Complex report generation 10x faster'
        }
    ];

    const tools = [
        { name: 'New Relic', description: 'Application performance monitoring' },
        { name: 'Blackfire.io', description: 'PHP profiling and optimization' },
        { name: 'Redis', description: 'In-memory caching and sessions' },
        { name: 'Laravel Telescope', description: 'Debug and optimize queries' },
        { name: 'CloudFlare CDN', description: 'Global content delivery' },
        { name: 'Laravel Horizon', description: 'Queue monitoring and optimization' }
    ];

    return (
        <div className={`min-h-screen ${isDarkMode ? 'bg-gray-950 text-gray-100' : 'bg-gray-50 text-gray-900'}`}>
            {/* Hero Section */}
            <section className={`relative overflow-hidden ${isDarkMode ? 'bg-gradient-to-br from-gray-900 via-gray-900 to-green-950' : 'bg-gradient-to-br from-white via-green-50 to-white'} border-b ${isDarkMode ? 'border-gray-800' : 'border-gray-200'}`}>
                <div className="absolute inset-0 opacity-10">
                    <div className="absolute top-0 left-1/4 w-96 h-96 bg-green-500 rounded-full blur-3xl"></div>
                    <div className="absolute bottom-0 right-1/4 w-96 h-96 bg-emerald-500 rounded-full blur-3xl"></div>
                </div>
                <div className="relative max-w-6xl mx-auto px-6 py-20 md:py-28">
                    <div className="inline-flex items-center gap-2 text-xs uppercase tracking-widest text-green-500 font-semibold mb-6">
                        <span className="h-2 w-2 rounded-full bg-green-500 animate-pulse" />
                        Performance Optimization Services
                    </div>
                    <h1 className="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight mb-6">
                        Make Your App{' '}
                        <span className="bg-gradient-to-r from-green-500 to-emerald-500 bg-clip-text text-transparent">
                            Lightning Fast
                        </span>
                    </h1>
                    <p className={`text-xl leading-relaxed max-w-3xl mb-8 ${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                        Professional performance optimization services for Laravel applications. Speed up slow queries, reduce server load, and improve user experience with proven optimization techniques.
                    </p>
                    <div className="flex flex-wrap gap-4">
                        <a
                            href="/contact"
                            className={`px-6 py-3 rounded-xl text-base font-semibold transition-all ${
                                isDarkMode ? 'bg-white text-gray-900 hover:bg-gray-100' : 'bg-gray-900 text-white hover:bg-gray-800'
                            } shadow-lg hover:shadow-xl`}
                        >
                            <i className="fas fa-rocket mr-2" />
                            Optimize My Application
                        </a>
                        <a
                            href="/case-studies"
                            className={`px-6 py-3 rounded-xl text-base font-semibold border-2 transition-all ${
                                isDarkMode ? 'border-gray-700 text-gray-200 hover:border-gray-600' : 'border-gray-300 text-gray-700 hover:border-gray-400'
                            }`}
                        >
                            <i className="fas fa-chart-line mr-2" />
                            View Results
                        </a>
                    </div>
                </div>
            </section>

            {/* Performance Metrics */}
            <section className="max-w-6xl mx-auto px-6 py-20">
                <div className="text-center mb-12">
                    <h2 className="text-3xl md:text-4xl font-bold mb-4">Typical Performance Improvements</h2>
                    <p className={`text-lg ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                        Real metrics from actual optimization projects
                    </p>
                </div>
                <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    {performanceMetrics.map((item) => (
                        <div
                            key={item.metric}
                            className={`rounded-xl border p-6 text-center ${isDarkMode ? 'border-gray-800 bg-gray-900' : 'border-gray-200 bg-white'}`}
                        >
                            <div className="mb-4 flex justify-center">
                                <div className="h-14 w-14 rounded-full bg-green-500/10 text-green-500 flex items-center justify-center">
                                    <i className={`${item.icon} text-2xl`} />
                                </div>
                            </div>
                            <h3 className="font-bold mb-3">{item.metric}</h3>
                            <div className={`text-sm space-y-1 ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                                <div className="flex items-center justify-center gap-2">
                                    <span className="text-red-500">Before:</span>
                                    <span>{item.before}</span>
                                </div>
                                <div className="flex items-center justify-center gap-2">
                                    <span className="text-green-500">After:</span>
                                    <span className="font-semibold">{item.after}</span>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </section>

            {/* Optimization Areas */}
            <section className={`py-20 ${isDarkMode ? 'bg-gray-900/50' : 'bg-gray-100/50'}`}>
                <div className="max-w-6xl mx-auto px-6">
                    <div className="text-center mb-12">
                        <h2 className="text-3xl md:text-4xl font-bold mb-4">What I Optimize</h2>
                        <p className={`text-lg ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                            Comprehensive optimization across all performance-critical areas
                        </p>
                    </div>
                    <div className="grid gap-6 md:grid-cols-2">
                        {optimizationAreas.map((area) => (
                            <div
                                key={area.title}
                                className={`rounded-2xl border p-8 ${isDarkMode ? 'border-gray-800 bg-gray-900' : 'border-gray-200 bg-white'}`}
                            >
                                <div className="flex items-start gap-4 mb-4">
                                    <div className="h-12 w-12 rounded-xl bg-gradient-to-br from-green-500 to-emerald-500 text-white flex items-center justify-center flex-shrink-0">
                                        <i className={area.icon} />
                                    </div>
                                    <div>
                                        <h3 className="text-xl font-bold mb-2">{area.title}</h3>
                                        <p className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>{area.description}</p>
                                    </div>
                                </div>
                                <div className="mb-4">
                                    <div className="flex flex-wrap gap-2">
                                        {area.techniques.map((tech) => (
                                            <span
                                                key={tech}
                                                className={`px-3 py-1 rounded-lg text-xs font-medium ${
                                                    isDarkMode ? 'bg-gray-800 text-gray-300' : 'bg-gray-100 text-gray-700'
                                                }`}
                                            >
                                                {tech}
                                            </span>
                                        ))}
                                    </div>
                                </div>
                                <div className={`text-sm font-semibold ${isDarkMode ? 'text-green-400' : 'text-green-600'}`}>
                                    <i className="fas fa-check-circle mr-2" />
                                    {area.impact}
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Optimization Process */}
            <section className="max-w-6xl mx-auto px-6 py-20">
                <div className="text-center mb-12">
                    <h2 className="text-3xl md:text-4xl font-bold mb-4">My Optimization Process</h2>
                    <p className={`text-lg ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                        Systematic approach to finding and fixing performance issues
                    </p>
                </div>
                <div className="grid gap-6 md:grid-cols-2">
                    {optimizationProcess.map((item) => (
                        <div
                            key={item.step}
                            className={`rounded-xl border p-6 ${isDarkMode ? 'border-gray-800 bg-gray-900' : 'border-gray-200 bg-white'}`}
                        >
                            <div className="flex items-center gap-4 mb-4">
                                <div className="h-12 w-12 rounded-full bg-gradient-to-br from-green-500 to-emerald-500 text-white flex items-center justify-center font-bold text-xl">
                                    {item.step}
                                </div>
                                <h3 className="text-xl font-bold">{item.title}</h3>
                            </div>
                            <p className={`mb-4 ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>{item.description}</p>
                            <div className="flex flex-wrap gap-2">
                                {item.tools.map((tool) => (
                                    <span
                                        key={tool}
                                        className={`px-2 py-1 rounded text-xs ${
                                            isDarkMode ? 'bg-gray-800 text-gray-400' : 'bg-gray-100 text-gray-600'
                                        }`}
                                    >
                                        {tool}
                                    </span>
                                ))}
                            </div>
                        </div>
                    ))}
                </div>
            </section>

            {/* Common Issues */}
            <section className={`py-20 ${isDarkMode ? 'bg-gray-900/50' : 'bg-gray-100/50'}`}>
                <div className="max-w-6xl mx-auto px-6">
                    <div className="text-center mb-12">
                        <h2 className="text-3xl md:text-4xl font-bold mb-4">Common Performance Issues I Fix</h2>
                        <p className={`text-lg ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                            Problems I encounter and solve regularly
                        </p>
                    </div>
                    <div className="grid gap-4">
                        {commonIssues.map((item) => (
                            <div
                                key={item.issue}
                                className={`rounded-xl border p-6 ${isDarkMode ? 'border-gray-800 bg-gray-900' : 'border-gray-200 bg-white'}`}
                            >
                                <div className="flex flex-col md:flex-row md:items-center gap-4">
                                    <div className="md:w-1/3">
                                        <div className="flex items-center gap-2 mb-2">
                                            <i className="fas fa-exclamation-triangle text-red-500" />
                                            <h3 className="font-bold">{item.issue}</h3>
                                        </div>
                                    </div>
                                    <div className="md:w-1/3">
                                        <div className="flex items-center gap-2 mb-2">
                                            <i className="fas fa-wrench text-blue-500" />
                                            <span className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>{item.solution}</span>
                                        </div>
                                    </div>
                                    <div className="md:w-1/3">
                                        <div className="flex items-center gap-2">
                                            <i className="fas fa-check-circle text-green-500" />
                                            <span className={`text-sm font-medium ${isDarkMode ? 'text-green-400' : 'text-green-600'}`}>{item.example}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Tools Section */}
            <section className="max-w-6xl mx-auto px-6 py-20">
                <div className="text-center mb-12">
                    <h2 className="text-3xl md:text-4xl font-bold mb-4">Tools & Technologies</h2>
                    <p className={`text-lg ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                        Professional tools for performance analysis and optimization
                    </p>
                </div>
                <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    {tools.map((tool) => (
                        <div
                            key={tool.name}
                            className={`rounded-xl border p-4 ${isDarkMode ? 'border-gray-800 bg-gray-900' : 'border-gray-200 bg-white'}`}
                        >
                            <h4 className="font-bold mb-1">{tool.name}</h4>
                            <p className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>{tool.description}</p>
                        </div>
                    ))}
                </div>
            </section>

            {/* CTA Section */}
            <section className="max-w-6xl mx-auto px-6 py-20">
                <div className={`rounded-2xl border p-12 text-center ${isDarkMode ? 'border-gray-800 bg-gradient-to-br from-gray-900 to-green-950' : 'border-gray-200 bg-gradient-to-br from-green-50 to-emerald-50'}`}>
                    <h2 className="text-3xl md:text-4xl font-bold mb-4">Ready to Speed Up Your Application?</h2>
                    <p className={`text-lg ${isDarkMode ? 'text-gray-300' : 'text-gray-600'} mb-8 max-w-2xl mx-auto`}>
                        Get a free performance audit and see where your application can be optimized.
                    </p>
                    <a
                        href="/contact"
                        className={`inline-block px-8 py-4 rounded-xl text-base font-semibold transition-all ${
                            isDarkMode ? 'bg-white text-gray-900 hover:bg-gray-100' : 'bg-gray-900 text-white hover:bg-gray-800'
                        } shadow-lg hover:shadow-xl`}
                    >
                        <i className="fas fa-paper-plane mr-2" />
                        Request Performance Audit
                    </a>
                </div>
            </section>
        </div>
    );
};

export default ServicesPerformance;
