import React, { useState } from 'react';

const CaseStudies = ({ isDarkMode }) => {
    const [selectedCase, setSelectedCase] = useState(null);

    const cases = [
        {
            title: 'Marketplace API Optimization',
            category: 'Performance',
            client: 'E-commerce Marketplace',
            duration: '3 months',
            problem: 'Slow API responses created checkout delays and poor user experience. Average response times exceeded 2 seconds during peak traffic, resulting in cart abandonment rates above 35%.',
            challenge: 'The existing API architecture wasn\'t optimized for scale. Database queries were inefficient, there was no caching layer, and N+1 query problems plagued the checkout flow.',
            approach: [
                'Profiled all API endpoints to identify bottlenecks',
                'Implemented Redis caching for frequently accessed data',
                'Optimized database queries with proper indexing',
                'Added database query monitoring and alerting',
                'Implemented API response compression'
            ],
            outcome: 'Reduced response time by 60% with query tuning and caching. Cart abandonment dropped to 18%, and checkout completion rates increased by 42%.',
            metrics: [
                { label: 'Response Time', value: '60% faster', icon: 'fas fa-tachometer-alt' },
                { label: 'Cart Abandonment', value: '17% reduction', icon: 'fas fa-shopping-cart' },
                { label: 'Checkout Rate', value: '42% increase', icon: 'fas fa-check-circle' },
                { label: 'Server Load', value: '35% decrease', icon: 'fas fa-server' }
            ],
            technologies: ['Laravel', 'Redis', 'MySQL', 'New Relic', 'Nginx'],
            testimonial: 'The performance improvements were immediate and dramatic. Our customers noticed the difference right away.',
            icon: 'fas fa-rocket',
            color: 'indigo'
        },
        {
            title: 'SaaS Dashboard Rebuild',
            category: 'UI/UX',
            client: 'B2B SaaS Company',
            duration: '4 months',
            problem: 'Fragmented admin tools across multiple legacy systems slowed teams and created confusion. Support tickets related to UI issues increased by 200% over the previous year.',
            challenge: 'The client had 5 different admin interfaces built over 7 years with different technologies. Users had to log in multiple times and learn different UIs for related tasks.',
            approach: [
                'Conducted user research and created unified design system',
                'Built single-page React application with role-based views',
                'Implemented comprehensive permission system',
                'Created REST API to unify backend services',
                'Conducted extensive user testing before launch'
            ],
            outcome: 'Unified the workflow into a clean dashboard with role-based access. Support tickets decreased by 65%, and admin task completion time dropped by 45%.',
            metrics: [
                { label: 'Support Tickets', value: '65% reduction', icon: 'fas fa-ticket-alt' },
                { label: 'Task Completion', value: '45% faster', icon: 'fas fa-clock' },
                { label: 'User Satisfaction', value: '4.8/5 rating', icon: 'fas fa-star' },
                { label: 'Training Time', value: '50% less', icon: 'fas fa-graduation-cap' }
            ],
            technologies: ['React', 'Laravel', 'Tailwind CSS', 'Redis', 'PostgreSQL'],
            testimonial: 'This has transformed how our team works. Everything is now in one place and incredibly intuitive.',
            icon: 'fas fa-chart-line',
            color: 'purple'
        },
        {
            title: 'Content Platform SEO Boost',
            category: 'SEO',
            client: 'Digital Publishing Company',
            duration: '5 months',
            problem: 'Low organic traffic despite strong content library. The platform had 10,000+ articles but was barely visible in search results, getting only 50K monthly organic visits.',
            challenge: 'The CMS wasn\'t built with SEO in mind. Pages loaded slowly, images weren\'t optimized, there was no schema markup, and the URL structure was problematic.',
            approach: [
                'Implemented comprehensive technical SEO audit',
                'Added automatic schema.org markup for articles',
                'Optimized images and implemented lazy loading',
                'Restructured URLs and implemented proper redirects',
                'Added CDN for global content delivery',
                'Implemented server-side rendering for better indexing'
            ],
            outcome: 'Improved search visibility and tripled organic traffic within 5 months. The site now ranks on the first page for 500+ target keywords.',
            metrics: [
                { label: 'Organic Traffic', value: '3x increase', icon: 'fas fa-chart-area' },
                { label: 'Page Load Time', value: '2.1s average', icon: 'fas fa-stopwatch' },
                { label: 'SEO Score', value: '95/100', icon: 'fas fa-trophy' },
                { label: 'Page 1 Rankings', value: '500+ keywords', icon: 'fas fa-search' }
            ],
            technologies: ['Laravel', 'Next.js', 'CloudFlare CDN', 'Schema.org', 'Google Analytics'],
            testimonial: 'Our content is finally getting the visibility it deserves. Traffic and engagement have skyrocketed.',
            icon: 'fas fa-search-plus',
            color: 'green'
        },
        {
            title: 'Payment Gateway Integration',
            category: 'Integration',
            client: 'Subscription Platform',
            duration: '2 months',
            problem: 'Single payment provider caused issues when payments failed. The platform had a 12% payment failure rate and couldn\'t serve international customers effectively.',
            challenge: 'The existing system was tightly coupled to one payment provider. Adding new providers would require significant refactoring, and there was no fallback mechanism.',
            approach: [
                'Designed abstraction layer for multiple payment providers',
                'Integrated Stripe, PayPal, and local payment methods',
                'Implemented automatic retry logic with fallback providers',
                'Added webhook handling for payment confirmations',
                'Created comprehensive payment reconciliation dashboard'
            ],
            outcome: 'Payment success rate increased to 98% with automatic fallbacks. International revenue grew by 180% after adding local payment methods.',
            metrics: [
                { label: 'Payment Success', value: '98% rate', icon: 'fas fa-credit-card' },
                { label: 'Failed Transactions', value: '86% reduction', icon: 'fas fa-times-circle' },
                { label: 'International Revenue', value: '180% growth', icon: 'fas fa-globe' },
                { label: 'Payment Options', value: '3 gateways', icon: 'fas fa-wallet' }
            ],
            technologies: ['Laravel', 'Stripe', 'PayPal', 'Webhooks', 'Queue Jobs'],
            testimonial: 'The redundancy and flexibility in payment processing has been a game-changer for our business.',
            icon: 'fas fa-credit-card',
            color: 'blue'
        },
        {
            title: 'Real-time Notification System',
            category: 'Architecture',
            client: 'Collaboration Platform',
            duration: '3 months',
            problem: 'Users were missing important updates because notifications arrived minutes late. The polling-based system created unnecessary server load.',
            challenge: 'The old system polled the server every 30 seconds for updates. This didn\'t scale well and still resulted in delayed notifications.',
            approach: [
                'Implemented WebSocket-based real-time communication',
                'Built Laravel Broadcasting with Redis',
                'Created notification preference system',
                'Added push notification support for mobile',
                'Implemented notification history and read status'
            ],
            outcome: 'Instant notifications reduced missed updates by 95%. Server load decreased by 40% by eliminating constant polling.',
            metrics: [
                { label: 'Notification Speed', value: 'Instant delivery', icon: 'fas fa-bolt' },
                { label: 'Missed Updates', value: '95% reduction', icon: 'fas fa-bell' },
                { label: 'Server Load', value: '40% decrease', icon: 'fas fa-server' },
                { label: 'User Engagement', value: '60% increase', icon: 'fas fa-users' }
            ],
            technologies: ['Laravel', 'WebSockets', 'Redis', 'Pusher', 'Vue.js'],
            testimonial: 'Real-time notifications have dramatically improved how our users collaborate and stay informed.',
            icon: 'fas fa-bell',
            color: 'orange'
        }
    ];

    const colorClasses = {
        indigo: 'from-indigo-500 to-purple-500',
        purple: 'from-purple-500 to-pink-500',
        green: 'from-green-500 to-emerald-500',
        blue: 'from-blue-500 to-cyan-500',
        orange: 'from-orange-500 to-red-500'
    };

    return (
        <div className={`min-h-screen ${isDarkMode ? 'bg-gray-950 text-gray-100' : 'bg-gray-50 text-gray-900'}`}>
            {/* Hero Section */}
            <section className={`relative overflow-hidden ${isDarkMode ? 'bg-gradient-to-br from-gray-900 via-gray-900 to-green-950' : 'bg-gradient-to-br from-white via-green-50 to-white'} border-b ${isDarkMode ? 'border-gray-800' : 'border-gray-200'}`}>
                <div className="absolute inset-0 opacity-10">
                    <div className="absolute top-0 left-1/4 w-96 h-96 bg-green-500 rounded-full blur-3xl"></div>
                    <div className="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-500 rounded-full blur-3xl"></div>
                </div>
                <div className="relative max-w-6xl mx-auto px-6 py-20 md:py-28">
                    <div className="inline-flex items-center gap-2 text-xs uppercase tracking-widest text-indigo-500 font-semibold mb-6">
                        <span className="h-2 w-2 rounded-full bg-indigo-500 animate-pulse" />
                        Case Studies
                    </div>
                    <h1 className="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight mb-6">
                        Real <span className="bg-gradient-to-r from-green-500 to-blue-500 bg-clip-text text-transparent">Results</span>
                    </h1>
                    <p className={`text-xl leading-relaxed max-w-3xl ${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                        In-depth case studies showcasing real problems, our solutions, and measurable outcomes. Each project demonstrates our commitment to delivering tangible business value.
                    </p>
                </div>
            </section>

            {/* Case Studies Grid */}
            <section className="max-w-6xl mx-auto px-6 py-20">
                <div className="grid gap-8">
                    {cases.map((item, index) => (
                        <div
                            key={item.title}
                            className={`group rounded-2xl border shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden ${
                                isDarkMode ? 'border-gray-800 bg-gray-900' : 'border-gray-200 bg-white'
                            }`}
                        >
                            <div className={`h-2 bg-gradient-to-r ${colorClasses[item.color]}`} />
                            <div className="p-8 md:p-10">
                                <div className="flex flex-col lg:flex-row gap-8">
                                    {/* Left Column */}
                                    <div className="lg:w-2/3">
                                        <div className="flex items-start gap-4 mb-6">
                                            <div className={`h-16 w-16 rounded-2xl bg-gradient-to-br ${colorClasses[item.color]} text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform flex-shrink-0`}>
                                                <i className={`${item.icon} text-2xl`} />
                                            </div>
                                            <div>
                                                <span className={`inline-block px-3 py-1 rounded-full text-xs font-semibold mb-2 ${
                                                    isDarkMode ? 'bg-gray-800 text-gray-300' : 'bg-gray-100 text-gray-700'
                                                }`}>
                                                    {item.category}
                                                </span>
                                                <h2 className="text-3xl font-bold">{item.title}</h2>
                                                <div className={`flex flex-wrap gap-4 mt-2 text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                                                    <span><i className="fas fa-building mr-2" />{item.client}</span>
                                                    <span><i className="fas fa-clock mr-2" />{item.duration}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div className="space-y-6">
                                            <div>
                                                <h3 className="text-lg font-bold mb-2 text-red-500">The Problem</h3>
                                                <p className={`${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>{item.problem}</p>
                                            </div>

                                            <div>
                                                <h3 className="text-lg font-bold mb-2 text-yellow-500">The Challenge</h3>
                                                <p className={`${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>{item.challenge}</p>
                                            </div>

                                            <div>
                                                <h3 className="text-lg font-bold mb-3 text-blue-500">Our Approach</h3>
                                                <ul className="space-y-2">
                                                    {item.approach.map((step, i) => (
                                                        <li key={i} className={`flex items-start gap-3 ${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                                                            <i className="fas fa-check-circle text-green-500 mt-1" />
                                                            <span>{step}</span>
                                                        </li>
                                                    ))}
                                                </ul>
                                            </div>

                                            <div>
                                                <h3 className="text-lg font-bold mb-2 text-green-500">The Outcome</h3>
                                                <p className={`${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>{item.outcome}</p>
                                            </div>

                                            <div className={`rounded-xl p-6 border-l-4 border-indigo-500 ${isDarkMode ? 'bg-gray-800/50' : 'bg-gray-50'}`}>
                                                <i className="fas fa-quote-left text-indigo-500 mb-2" />
                                                <p className={`italic ${isDarkMode ? 'text-gray-300' : 'text-gray-700'}`}>"{item.testimonial}"</p>
                                            </div>
                                        </div>
                                    </div>

                                    {/* Right Column */}
                                    <div className="lg:w-1/3 space-y-6">
                                        <div>
                                            <h3 className="text-lg font-bold mb-4">Key Metrics</h3>
                                            <div className="grid gap-4">
                                                {item.metrics.map((metric) => (
                                                    <div
                                                        key={metric.label}
                                                        className={`rounded-xl p-4 ${isDarkMode ? 'bg-gray-800' : 'bg-gray-100'}`}
                                                    >
                                                        <div className="flex items-center gap-3 mb-2">
                                                            <div className={`h-10 w-10 rounded-lg bg-gradient-to-br ${colorClasses[item.color]} text-white flex items-center justify-center`}>
                                                                <i className={metric.icon} />
                                                            </div>
                                                            <div className="text-2xl font-bold text-indigo-500">{metric.value}</div>
                                                        </div>
                                                        <div className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>{metric.label}</div>
                                                    </div>
                                                ))}
                                            </div>
                                        </div>

                                        <div>
                                            <h3 className="text-lg font-bold mb-4">Technologies Used</h3>
                                            <div className="flex flex-wrap gap-2">
                                                {item.technologies.map((tech) => (
                                                    <span
                                                        key={tech}
                                                        className={`px-3 py-1.5 rounded-lg text-xs font-medium ${
                                                            isDarkMode ? 'bg-gray-800 text-gray-300' : 'bg-gray-100 text-gray-700'
                                                        }`}
                                                    >
                                                        {tech}
                                                    </span>
                                                ))}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </section>

            {/* Stats Section */}
            <section className={`py-16 ${isDarkMode ? 'bg-gray-900/50' : 'bg-gray-100/50'}`}>
                <div className="max-w-6xl mx-auto px-6">
                    <div className="text-center mb-12">
                        <h2 className="text-3xl md:text-4xl font-bold mb-4">Our Impact</h2>
                        <p className={`text-lg ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                            Measurable results across all our projects
                        </p>
                    </div>
                    <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div className={`rounded-xl p-6 text-center ${isDarkMode ? 'bg-gray-900' : 'bg-white'}`}>
                            <div className="text-4xl font-bold text-indigo-500 mb-2">95%</div>
                            <div className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>Client Satisfaction</div>
                        </div>
                        <div className={`rounded-xl p-6 text-center ${isDarkMode ? 'bg-gray-900' : 'bg-white'}`}>
                            <div className="text-4xl font-bold text-green-500 mb-2">60%</div>
                            <div className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>Avg Performance Gain</div>
                        </div>
                        <div className={`rounded-xl p-6 text-center ${isDarkMode ? 'bg-gray-900' : 'bg-white'}`}>
                            <div className="text-4xl font-bold text-purple-500 mb-2">100%</div>
                            <div className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>On-Time Delivery</div>
                        </div>
                        <div className={`rounded-xl p-6 text-center ${isDarkMode ? 'bg-gray-900' : 'bg-white'}`}>
                            <div className="text-4xl font-bold text-orange-500 mb-2">50+</div>
                            <div className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>Successful Projects</div>
                        </div>
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className="max-w-6xl mx-auto px-6 py-20">
                <div className={`rounded-2xl border p-12 text-center ${isDarkMode ? 'border-gray-800 bg-gradient-to-br from-gray-900 to-green-950' : 'border-gray-200 bg-gradient-to-br from-green-50 to-blue-50'}`}>
                    <h2 className="text-3xl md:text-4xl font-bold mb-4">Ready to Achieve Similar Results?</h2>
                    <p className={`text-lg ${isDarkMode ? 'text-gray-300' : 'text-gray-600'} mb-8 max-w-2xl mx-auto`}>
                        Let's discuss your project challenges and explore how we can deliver measurable improvements to your business.
                    </p>
                    <div className="flex flex-wrap gap-4 justify-center">
                        <a
                            href="/contact"
                            className={`px-8 py-4 rounded-xl text-base font-semibold transition-all ${
                                isDarkMode ? 'bg-white text-gray-900 hover:bg-gray-100' : 'bg-gray-900 text-white hover:bg-gray-800'
                            } shadow-lg hover:shadow-xl`}
                        >
                            Start Your Project
                        </a>
                        <a
                            href="/projects"
                            className={`px-8 py-4 rounded-xl text-base font-semibold border-2 transition-all ${
                                isDarkMode ? 'border-gray-700 text-gray-200 hover:border-gray-600' : 'border-gray-300 text-gray-700 hover:border-gray-400'
                            }`}
                        >
                            View All Projects
                        </a>
                    </div>
                </div>
            </section>
        </div>
    );
};

export default CaseStudies;
