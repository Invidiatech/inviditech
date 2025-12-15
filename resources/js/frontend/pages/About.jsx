import React from 'react';
const About = ({ isDarkMode }) => {
    const skills = [
        { name: "Laravel", icon: "fab fa-laravel", color: "text-red-500" },
        { name: "Livewire", icon: "fas fa-bolt", color: "text-pink-500" },
        { name: "Vue.js", icon: "fab fa-vuejs", color: "text-green-500" },
        { name: "React / Next.js", icon: "fab fa-react", color: "text-blue-400" },
        { name: "JavaScript (ES6+)", icon: "fab fa-js-square", color: "text-yellow-400" },
        { name: "Node.js", icon: "fab fa-node-js", color: "text-green-600" },
        { name: "PHP", icon: "fab fa-php", color: "text-indigo-400" },
        { name: "MySQL / Database Design", icon: "fas fa-database", color: "text-blue-400" },
        { name: "API Integration (REST / GraphQL)", icon: "fas fa-plug", color: "text-teal-400" },
        { name: "Tailwind CSS", icon: "fas fa-palette", color: "text-cyan-400" },
        { name: "Bootstrap", icon: "fab fa-bootstrap", color: "text-purple-500" },
        { name: "Git / GitHub / GitLab", icon: "fas fa-code-branch", color: "text-orange-500" },
        { name: "Server Deployment (cPanel / VPS / Nginx)", icon: "fas fa-server", color: "text-gray-500" },
        { name: "Linux & Command Line", icon: "fas fa-terminal", color: "text-gray-400" },
        { name: "WordPress / WooCommerce", icon: "fab fa-wordpress", color: "text-blue-500" },
        { name: "Crocoblock JetPlugins", icon: "fas fa-cube", color: "text-emerald-400" },
        { name: "Elementor / Theme Customization", icon: "fas fa-layer-group", color: "text-pink-400" },
        { name: "API Testing (Postman / Thunder Client)", icon: "fas fa-vial", color: "text-amber-400" },
        { name: "Performance Optimization", icon: "fas fa-gauge-high", color: "text-green-400" },
        { name: "SEO & Analytics", icon: "fas fa-chart-line", color: "text-indigo-500" },
      ];
      

    const stats = [
        { number: "2+", label: "Years Experience", icon: "fas fa-briefcase" },
        { number: "50+", label: "Projects Completed", icon: "fas fa-project-diagram" },
        { number: "30+", label: "Happy Clients", icon: "fas fa-smile" },
        { number: "25+", label: "Articles Written", icon: "fas fa-pencil-alt" }
    ];

    return (
        <div className={`min-h-screen py-12 ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
            {/* Background Pattern */}
            <div className="absolute inset-0 overflow-hidden opacity-5">
                <div className={`absolute top-20 right-20 w-40 h-40 rounded-full ${isDarkMode ? 'bg-indigo-500' : 'bg-indigo-300'}`}></div>
                <div className={`absolute bottom-20 left-20 w-32 h-32 rounded-full ${isDarkMode ? 'bg-purple-500' : 'bg-purple-300'}`}></div>
            </div>

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                {/* Header Section */}
                <div className="text-center mb-20">
                    <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full border mb-6">
                        <div className="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></div>
                        <span className={`text-sm font-medium ${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                            About Me
                        </span>
                    </div>
                    
                    <h1 className={`text-5xl md:text-6xl font-bold mb-6 bg-gradient-to-r ${
                        isDarkMode 
                            ? 'from-white to-gray-400' 
                            : 'from-gray-900 to-gray-600'
                    } bg-clip-text text-transparent`}>
                        Full-Stack Engineer
                        <span className="block text-indigo-400">& Technical Writer</span>
                    </h1>
                    
                    <p className={`text-xl max-w-3xl mx-auto leading-relaxed ${
                        isDarkMode ? 'text-gray-300' : 'text-gray-600'
                    }`}>
                        Building intelligent, scalable, and performance-driven web applications that deliver real business value.
                    </p>
                </div>

                {/* Main Content Grid */}
                <div className="grid lg:grid-cols-2 gap-16 items-center mb-20">
                    {/* Left Column - Text Content */}
                    <div className="space-y-8">
                        <div className={`p-8 rounded-2xl backdrop-blur-lg border ${
                            isDarkMode 
                                ? 'bg-gray-800/40 border-gray-700' 
                                : 'bg-white/70 border-gray-200'
                        }`}>
                            <h2 className={`text-3xl font-bold mb-6 flex items-center gap-3 ${
                                isDarkMode ? 'text-white' : 'text-gray-900'
                            }`}>
                                
                                My Mission
                            </h2>
                            <p className={`mb-6 text-lg leading-relaxed ${
                                isDarkMode ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                                With over 2 years of experience in full-stack development, I specialize in building elegant, 
                                scalable, and performance-driven web solutions. I've worked with modern technologies to deliver 
                                exceptional results for clients worldwide.
                            </p>
                            <p className={`mb-6 text-lg leading-relaxed ${
                                isDarkMode ? 'text-gray-300' : 'text-gray-600'
                            }`}>
                                My focus is on turning complex ideas into production-ready digital systems that deliver 
                                measurable business value and outstanding user experiences.
                            </p>
                            
                            {/* Key Focus Areas */}
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8">
                                <div className={`flex items-center gap-3 p-4 rounded-xl ${
                                    isDarkMode ? 'bg-gray-700/50' : 'bg-gray-100'
                                }`}>
                                    <div className="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center">
                                        <i className="fas fa-rocket text-white"></i>
                                    </div>
                                    <span className={`font-medium ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                        Performance
                                    </span>
                                </div>
                                <div className={`flex items-center gap-3 p-4 rounded-xl ${
                                    isDarkMode ? 'bg-gray-700/50' : 'bg-gray-100'
                                }`}>
                                    <div className="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                        <i className="fas fa-expand-arrows-alt text-white"></i>
                                    </div>
                                    <span className={`font-medium ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                        Scalability
                                    </span>
                                </div>
                                <div className={`flex items-center gap-3 p-4 rounded-xl ${
                                    isDarkMode ? 'bg-gray-700/50' : 'bg-gray-100'
                                }`}>
                                    <div className="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                        <i className="fas fa-code text-white"></i>
                                    </div>
                                    <span className={`font-medium ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                        Clean Code
                                    </span>
                                </div>
                                <div className={`flex items-center gap-3 p-4 rounded-xl ${
                                    isDarkMode ? 'bg-gray-700/50' : 'bg-gray-100'
                                }`}>
                                    <div className="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <i className="fas fa-users text-white"></i>
                                    </div>
                                    <span className={`font-medium ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                        User Experience
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Right Column - Profile Image */}
                    <div className="relative">
                        <div className="relative group">
                            {/* Main Profile Image */}
                            <div className="relative w-80 h-80 mx-auto">
                                <img 
                                    src="/assets/profile/Muhammad Nawaz(Software Enginer).png" 
                                    alt="Muhammad Nawaz - Full-Stack Software Engineer" 
                                    className="w-full h-full object-cover rounded-2xl shadow-2xl border-4 border-white/20 group-hover:scale-105 transition-transform duration-500"
                                />
                                {/* Gradient Overlay */}
                                <div className="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-600/10 rounded-2xl group-hover:opacity-0 transition-opacity duration-500"></div>
                                
                                {/* Floating Tech Badges */}
                               
                               
                            </div>

                            {/* Background Glow */}
                            <div className="absolute inset-0 rounded-2xl bg-indigo-400/20 blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10"></div>
                        </div>

                        {/* Name and Title */}
                        <div className="text-center mt-8">
                            <h3 className={`text-2xl font-bold mb-2 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                Muhammad Nawaz
                            </h3>
                            <p className={`text-lg mb-4 ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                                Full-Stack Software Engineer & Technical Writer
                            </p>
                            <div className="flex justify-center gap-4">
                                <a href="mailto:sardarnawaz122@gmail.com" className={`p-3 rounded-full transition-all duration-300 ${
                                    isDarkMode 
                                        ? 'bg-gray-800 text-white hover:bg-indigo-500' 
                                        : 'bg-white text-gray-900 hover:bg-indigo-500 hover:text-white shadow-lg'
                                }`}>
                                    <i className="fas fa-envelope"></i>
                                </a>
                                <a href="https://www.linkedin.com/in/muhammad-nawaz-43a354201/" target="_blank" rel="noopener noreferrer" className={`p-3 rounded-full transition-all duration-300 ${
                                    isDarkMode 
                                        ? 'bg-gray-800 text-white hover:bg-blue-600' 
                                        : 'bg-white text-gray-900 hover:bg-blue-600 hover:text-white shadow-lg'
                                }`}>
                                    <i className="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://github.com/nawazfdev" target="_blank" rel="noopener noreferrer" className={`p-3 rounded-full transition-all duration-300 ${
                                    isDarkMode 
                                        ? 'bg-gray-800 text-white hover:bg-gray-600' 
                                        : 'bg-white text-gray-900 hover:bg-gray-900 hover:text-white shadow-lg'
                                }`}>
                                    <i className="fab fa-github"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Stats Section */}
                <div className={`grid grid-cols-2 lg:grid-cols-4 gap-6 mb-20 ${
                    isDarkMode ? 'text-white' : 'text-gray-900'
                }`}>
                    {stats.map((stat, index) => (
                        <div key={index} className={`text-center p-6 rounded-2xl backdrop-blur-lg border transition-all duration-300 hover:scale-105 ${
                            isDarkMode 
                                ? 'bg-gray-800/40 border-gray-700 hover:border-indigo-400' 
                                : 'bg-white/70 border-gray-200 hover:border-indigo-400'
                        }`}>
                            <div className="w-12 h-12 bg-indigo-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i className={`${stat.icon} text-white`}></i>
                            </div>
                            <div className="text-2xl font-bold text-indigo-400 mb-2">{stat.number}</div>
                            <div className="text-sm font-medium">{stat.label}</div>
                        </div>
                    ))}
                </div>

                {/* Skills Section */}
                <div className={`p-8 rounded-2xl backdrop-blur-lg border ${
                    isDarkMode 
                        ? 'bg-gray-800/40 border-gray-700' 
                        : 'bg-white/70 border-gray-200'
                }`}>
                    <h2 className={`text-3xl font-bold mb-8 text-center flex items-center justify-center gap-3 ${
                        isDarkMode ? 'text-white' : 'text-gray-900'
                    }`}>
                        <i className="fas fa-cogs text-indigo-400"></i>
                        Technical Skills
                    </h2>
                    <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                        {skills.map((skill, index) => (
                            <div key={index} className={`flex items-center gap-3 p-4 rounded-xl transition-all duration-300 hover:scale-105 ${
                                isDarkMode ? 'bg-gray-700/50 hover:bg-gray-600/50' : 'bg-gray-100 hover:bg-gray-200'
                            }`}>
                                <i className={`${skill.icon} ${skill.color} text-xl`}></i>
                                <span className={`font-medium ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                    {skill.name}
                                </span>
                            </div>
                        ))}
                    </div>
                </div>

                {/* Call to Action */}
                <div className="text-center mt-16">
                    <div className={`inline-flex items-center gap-4 px-8 py-6 rounded-2xl border backdrop-blur-lg ${
                        isDarkMode 
                            ? 'bg-gray-800/50 border-gray-700' 
                            : 'bg-white/50 border-gray-200'
                    }`}>
                        <div className="text-left">
                            <p className={`font-semibold text-lg ${
                                isDarkMode ? 'text-white' : 'text-gray-900'
                            }`}>
                                Ready to start your project?
                            </p>
                            <p className={`text-sm ${
                                isDarkMode ? 'text-gray-400' : 'text-gray-600'
                            }`}>
                                Let's build something amazing together
                            </p>
                        </div>
                        <a 
                              href="/contact"
                            className={`px-6 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center gap-2 ${
                                isDarkMode
                                    ? 'bg-indigo-500 text-white hover:bg-indigo-400'
                                    : 'bg-indigo-500 text-white hover:bg-indigo-400'
                            }`}
                        >
                            <i className="fas fa-paper-plane"></i>
                            Get In Touch
                        </a>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default About;