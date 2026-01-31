import React from 'react';

const Resume = ({ isDarkMode }) => {
    const experience = [
        {
            title: 'Full-Stack Developer',
            period: '2022 - Present',
            description: 'Building scalable web applications with Laravel, React, and modern technologies',
            highlights: [
                'Laravel backend development and API architecture',
                'Frontend development with React and Vue.js',
                'Database design and optimization',
                'Third-party integrations and payment gateways'
            ]
        }
    ];

    const skills = [
        {
            category: 'Backend',
            items: ['Laravel', 'PHP 8+', 'RESTful APIs', 'MySQL', 'PostgreSQL', 'Redis']
        },
        {
            category: 'Frontend',
            items: ['React', 'Vue.js', 'JavaScript', 'Tailwind CSS', 'HTML5', 'CSS3']
        },
        {
            category: 'Tools & DevOps',
            items: ['Git', 'Docker', 'GitHub Actions', 'Nginx', 'Linux', 'AWS']
        },
        {
            category: 'Other',
            items: ['RESTful API Design', 'Database Design', 'Performance Optimization', 'Security Best Practices']
        }
    ];

    const socialLinks = [
        {
            name: 'GitHub',
            icon: 'fab fa-github',
            url: 'https://github.com/yourusername',
            description: 'View my code and open-source contributions',
            color: 'from-gray-700 to-gray-900'
        },
        {
            name: 'LinkedIn',
            icon: 'fab fa-linkedin',
            url: 'https://linkedin.com/in/yourprofile',
            description: 'Connect with me professionally',
            color: 'from-blue-600 to-blue-800'
        },
        {
            name: 'Twitter',
            icon: 'fab fa-twitter',
            url: 'https://twitter.com/yourhandle',
            description: 'Follow me for tech updates',
            color: 'from-blue-400 to-blue-600'
        },
        {
            name: 'Stack Overflow',
            icon: 'fab fa-stack-overflow',
            url: 'https://stackoverflow.com/users/yourprofile',
            description: 'See my community contributions',
            color: 'from-orange-500 to-orange-700'
        }
    ];

    const achievements = [
        '25+ successful projects delivered to clients worldwide',
        'Built SaaS platforms handling thousands of users',
        'Optimized applications for 60%+ performance improvements',
        '100% client satisfaction rate with ongoing partnerships'
    ];

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
                        <div className="inline-flex items-center gap-2 text-xs uppercase tracking-widest text-blue-500 font-semibold mb-6">
                            <span className="h-2 w-2 rounded-full bg-blue-500 animate-pulse" />
                            Resume & CV
                        </div>
                        <h1 className="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight mb-6">
                            Muhammad <span className="bg-gradient-to-r from-blue-500 to-indigo-500 bg-clip-text text-transparent">Nawaz</span>
                        </h1>
                        <p className={`text-2xl font-semibold mb-4 ${isDarkMode ? 'text-gray-300' : 'text-gray-700'}`}>
                            Full-Stack Developer
                        </p>
                        <p className={`text-lg leading-relaxed max-w-3xl mx-auto mb-8 ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                            Specializing in Laravel, React, and modern web development. Building scalable applications that solve real business problems.
                        </p>
                        
                        {/* Download CV Button */}
                        <div className="flex flex-wrap gap-4 justify-center mb-8">
                            <a
                                href="/cv/Muhammad Nawaz(Full-Stack Developer).pdf"
                                download
                                className={`px-8 py-4 rounded-xl text-base font-semibold transition-all ${
                                    isDarkMode ? 'bg-white text-gray-900 hover:bg-gray-100' : 'bg-gray-900 text-white hover:bg-gray-800'
                                } shadow-lg hover:shadow-xl inline-flex items-center gap-3`}
                            >
                                <i className="fas fa-file-download text-xl" />
                                <div className="text-left">
                                    <div>Download Full Resume</div>
                                    <div className="text-xs opacity-75">PDF Format</div>
                                </div>
                            </a>
                            <a
                                href="/contact"
                                className={`px-8 py-4 rounded-xl text-base font-semibold border-2 transition-all ${
                                    isDarkMode ? 'border-gray-700 text-gray-200 hover:border-gray-600' : 'border-gray-300 text-gray-700 hover:border-gray-400'
                                } inline-flex items-center gap-2`}
                            >
                                <i className="fas fa-envelope" />
                                Get in Touch
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            {/* Social Links */}
            <section className="max-w-6xl mx-auto px-6 py-16">
                <div className="text-center mb-8">
                    <h2 className="text-2xl md:text-3xl font-bold mb-3">Connect With Me</h2>
                    <p className={`${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                        Find me on social media and developer platforms
                    </p>
                </div>
                <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    {socialLinks.map((social) => (
                        <a
                            key={social.name}
                            href={social.url}
                            target="_blank"
                            rel="noopener noreferrer"
                            className={`group rounded-xl border p-6 text-center transition-all hover:shadow-xl ${
                                isDarkMode ? 'border-gray-800 bg-gray-900 hover:border-gray-700' : 'border-gray-200 bg-white hover:border-gray-300'
                            }`}
                        >
                            <div className="mb-4 flex justify-center">
                                <div className={`h-14 w-14 rounded-full bg-gradient-to-br ${social.color} text-white flex items-center justify-center text-2xl group-hover:scale-110 transition-transform`}>
                                    <i className={social.icon} />
                                </div>
                            </div>
                            <h3 className="font-bold mb-2">{social.name}</h3>
                            <p className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                                {social.description}
                            </p>
                            <div className={`mt-3 text-sm font-medium ${isDarkMode ? 'text-blue-400' : 'text-blue-600'}`}>
                                Visit Profile <i className="fas fa-arrow-right ml-1" />
                            </div>
                        </a>
                    ))}
                </div>
            </section>

            {/* Experience Section */}
            <section className={`py-16 ${isDarkMode ? 'bg-gray-900/50' : 'bg-gray-100/50'}`}>
                <div className="max-w-6xl mx-auto px-6">
                    <div className="text-center mb-12">
                        <h2 className="text-3xl md:text-4xl font-bold mb-4">Professional Experience</h2>
                        <p className={`text-lg ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                            My journey as a software developer
                        </p>
                    </div>
                    <div className="max-w-4xl mx-auto">
                        {experience.map((exp, index) => (
                            <div
                                key={index}
                                className={`rounded-2xl border p-8 mb-6 ${isDarkMode ? 'border-gray-800 bg-gray-900' : 'border-gray-200 bg-white'}`}
                            >
                                <div className="flex items-start gap-4 mb-4">
                                    <div className="h-12 w-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 text-white flex items-center justify-center flex-shrink-0">
                                        <i className="fas fa-briefcase" />
                                    </div>
                                    <div className="flex-1">
                                        <h3 className="text-2xl font-bold mb-1">{exp.title}</h3>
                                        <p className={`text-sm font-medium ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                                            <i className="fas fa-calendar mr-2" />
                                            {exp.period}
                                        </p>
                                    </div>
                                </div>
                                <p className={`mb-4 ${isDarkMode ? 'text-gray-300' : 'text-gray-700'}`}>
                                    {exp.description}
                                </p>
                                <div className="space-y-2">
                                    {exp.highlights.map((highlight, i) => (
                                        <div key={i} className="flex items-start gap-2">
                                            <i className="fas fa-check text-green-500 mt-1" />
                                            <span className={isDarkMode ? 'text-gray-400' : 'text-gray-600'}>{highlight}</span>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Skills Section */}
            <section className="max-w-6xl mx-auto px-6 py-16">
                <div className="text-center mb-12">
                    <h2 className="text-3xl md:text-4xl font-bold mb-4">Technical Skills</h2>
                    <p className={`text-lg ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                        Technologies and tools I work with
                    </p>
                </div>
                <div className="grid gap-6 md:grid-cols-2">
                    {skills.map((skillSet) => (
                        <div
                            key={skillSet.category}
                            className={`rounded-xl border p-6 ${isDarkMode ? 'border-gray-800 bg-gray-900' : 'border-gray-200 bg-white'}`}
                        >
                            <h3 className="text-xl font-bold mb-4 text-blue-500">
                                <i className="fas fa-layer-group mr-2" />
                                {skillSet.category}
                            </h3>
                            <div className="flex flex-wrap gap-2">
                                {skillSet.items.map((skill) => (
                                    <span
                                        key={skill}
                                        className={`px-3 py-2 rounded-lg text-sm font-medium ${
                                            isDarkMode ? 'bg-gray-800 text-gray-300' : 'bg-gray-100 text-gray-700'
                                        }`}
                                    >
                                        {skill}
                                    </span>
                                ))}
                            </div>
                        </div>
                    ))}
                </div>
            </section>

            {/* Achievements Section */}
            <section className={`py-16 ${isDarkMode ? 'bg-gray-900/50' : 'bg-gray-100/50'}`}>
                <div className="max-w-6xl mx-auto px-6">
                    <div className="text-center mb-12">
                        <h2 className="text-3xl md:text-4xl font-bold mb-4">Key Achievements</h2>
                        <p className={`text-lg ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                            Highlights of my professional journey
                        </p>
                    </div>
                    <div className="grid gap-4 md:grid-cols-2 max-w-4xl mx-auto">
                        {achievements.map((achievement, index) => (
                            <div
                                key={index}
                                className={`rounded-xl border p-6 flex items-start gap-4 ${
                                    isDarkMode ? 'border-gray-800 bg-gray-900' : 'border-gray-200 bg-white'
                                }`}
                            >
                                <div className="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 text-white flex items-center justify-center font-bold flex-shrink-0">
                                    {index + 1}
                                </div>
                                <p className={isDarkMode ? 'text-gray-300' : 'text-gray-700'}>{achievement}</p>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className="max-w-6xl mx-auto px-6 py-20">
                <div className={`rounded-2xl border p-12 text-center ${isDarkMode ? 'border-gray-800 bg-gradient-to-br from-gray-900 to-blue-950' : 'border-gray-200 bg-gradient-to-br from-blue-50 to-indigo-50'}`}>
                    <div className="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-500 text-white text-2xl mb-6 shadow-lg">
                        <i className="fas fa-handshake" />
                    </div>
                    <h2 className="text-3xl md:text-4xl font-bold mb-4">Let's Work Together</h2>
                    <p className={`text-lg ${isDarkMode ? 'text-gray-300' : 'text-gray-600'} mb-8 max-w-2xl mx-auto`}>
                        Interested in collaborating? Download my full resume or get in touch to discuss your project.
                    </p>
                    <div className="flex flex-wrap gap-4 justify-center">
                        <a
                            href="/cv/Muhammad Nawaz(Full-Stack Developer).pdf"
                            download
                            className={`px-8 py-4 rounded-xl text-base font-semibold transition-all ${
                                isDarkMode ? 'bg-white text-gray-900 hover:bg-gray-100' : 'bg-gray-900 text-white hover:bg-gray-800'
                            } shadow-lg hover:shadow-xl`}
                        >
                            <i className="fas fa-download mr-2" />
                            Download Resume
                        </a>
                        <a
                            href="/contact"
                            className={`px-8 py-4 rounded-xl text-base font-semibold border-2 transition-all ${
                                isDarkMode ? 'border-gray-700 text-gray-200 hover:border-gray-600' : 'border-gray-300 text-gray-700 hover:border-gray-400'
                            }`}
                        >
                            <i className="fas fa-envelope mr-2" />
                            Contact Me
                        </a>
                    </div>
                </div>
            </section>
        </div>
    );
};

export default Resume;
