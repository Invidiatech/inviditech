import React, { useState, useEffect } from 'react';

const Blog = ({ isDarkMode, blogData }) => {
    const [selectedCategory, setSelectedCategory] = useState('All');
    const [searchTerm, setSearchTerm] = useState('');
    const [blogs, setBlogs] = useState([]);
    const [categories, setCategories] = useState([]);
    const [viewMode, setViewMode] = useState('grid'); // 'grid' or 'list'
    // Calculate dynamic category counts from actual blog data
    const calculateCategoryCounts = (allBlogs) => {
        if (!allBlogs || allBlogs.length === 0) return {};
        const counts = {};
        allBlogs.forEach(blog => {
            const categoryName = blog.category || 'Uncategorized';
            counts[categoryName] = (counts[categoryName] || 0) + 1;
        });
        return counts;
    };

    // Initialize data from props
    useEffect(() => {
        if (blogData) {
            setBlogs(blogData.all || []);
            // Calculate dynamic counts
            const categoryCounts = calculateCategoryCounts(blogData.all || []);
            
            // Add 'All' option to categories and update counts dynamically
            const allCategories = [
                { id: 'all', name: 'All', slug: 'all', blogs_count: (blogData.all || []).length }
            ];
            
            // Map categories with dynamic counts
            if (blogData.categories) {
                blogData.categories.forEach(cat => {
                    allCategories.push({
                        ...cat,
                        blogs_count: categoryCounts[cat.name] || 0
                    });
                });
            }
            
            setCategories(allCategories);
        }
    }, [blogData]);

    // Filter blogs based on search and category - FIXED VERSION
    useEffect(() => {
        if (!blogData) return;

        let filteredBlogs = blogData.all || [];

        // Apply category filter - Fixed to handle null categories and case-insensitive matching
        if (selectedCategory !== 'All') {
            filteredBlogs = filteredBlogs.filter(blog => {
                const blogCategory = blog.category || '';
                return blogCategory.toString().toLowerCase().trim() === selectedCategory.toLowerCase().trim();
            });
        }

        // Apply search filter - Fixed to handle null/undefined values
        if (searchTerm) {
            const searchLower = searchTerm.toLowerCase().trim();
            filteredBlogs = filteredBlogs.filter(blog => {
                const title = (blog.title || '').toLowerCase();
                const excerpt = (blog.excerpt || '').toLowerCase();
                const tags = (blog.tags || []).some(tag => 
                    (tag?.name || '').toLowerCase().includes(searchLower)
                );
                return title.includes(searchLower) || excerpt.includes(searchLower) || tags;
            });
        }

        setBlogs(filteredBlogs);
    }, [selectedCategory, searchTerm, blogData]);

    const handleSearchChange = (e) => {
        setSearchTerm(e.target.value);
    };

    const handleCategoryChange = (category) => {
        setSelectedCategory(category);
    };

    const handleTagClick = (tagName) => {
        setSearchTerm(tagName);
    };

    const getCategoryColor = (categoryName) => {
        if (!categoryName) return 'from-gray-500 to-gray-700';
        const colors = {
            'Laravel': 'from-indigo-500 to-purple-600',
            'React': 'from-blue-500 to-cyan-600',
            'JavaScript': 'from-yellow-500 to-orange-600',
            'AI': 'from-purple-500 to-pink-600',
            'Performance': 'from-emerald-500 to-teal-600',
            'Architecture': 'from-orange-500 to-red-600',
            'Vue.js': 'from-green-500 to-emerald-600',
            'Node.js': 'from-green-600 to-green-800',
            'PHP': 'from-purple-600 to-indigo-800',
            'Database': 'from-blue-600 to-purple-800',
            'Eloquent ORM': 'from-indigo-500 to-purple-600',
            'Laravel APIs': 'from-blue-500 to-cyan-600',
            'Laravel Basics': 'from-indigo-500 to-purple-600',
        };
        return colors[categoryName] || 'from-gray-500 to-gray-700';
    };


    // Show loading state only if blogData is null/undefined
    if (blogData === null || blogData === undefined) {
        return (
            <div className={`min-h-screen flex items-center justify-center ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="text-center">
                    <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto mb-4"></div>
                    <p className={`${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>Loading blogs...</p>
                </div>
            </div>
        );
    }

    const popularBlogs = blogData?.popular || [];
    const recentBlogs = blogData?.recent || [];
    const popularTags = blogData?.tags || [];

    return (
        <div className={`min-h-screen ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
            {/* Hero Section */}
            <section className={`pt-24 pb-16 px-4 sm:px-6 lg:px-8 ${isDarkMode ? 'bg-gray-800' : 'bg-gray-50'} border-b ${isDarkMode ? 'border-gray-700' : 'border-gray-200'}`}>
                <div className="max-w-7xl mx-auto text-center">
                    <h1 className={`text-5xl md:text-6xl font-bold mb-6 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                        Latest Blog Posts
                    </h1>
                    <p className={`text-xl mb-8 max-w-3xl mx-auto ${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                        Sharing knowledge and insights from my development journey. Explore articles on modern web development, architecture, and best practices.
                    </p>
                </div>
            </section>

            {/* Search and Filter Section */}
            <section className={`py-8 px-4 sm:px-6 lg:px-8 ${isDarkMode ? 'bg-gray-900' : 'bg-white'} border-b ${isDarkMode ? 'border-gray-800' : 'border-gray-200'}`}>
                <div className="max-w-7xl mx-auto">
                    <div className="flex flex-col md:flex-row gap-6 items-center justify-between mb-4">
                        {/* Search Bar */}
                        <div className="relative flex-1 max-w-md">
                            <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg className="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input
                                type="text"
                                placeholder="Search articles..."
                                value={searchTerm}
                                onChange={handleSearchChange}
                                className={`block w-full pl-10 pr-3 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 ${
                                    isDarkMode 
                                        ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' 
                                        : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 shadow-sm'
                                }`}
                            />
                        </div>

                        {/* View Mode Toggle & Results Count */}
                        <div className="flex items-center gap-3">
                            {/* View Mode Toggle */}
                            <div className={`flex rounded-lg overflow-hidden border ${isDarkMode ? 'border-gray-600' : 'border-gray-300'}`}>
                                <button
                                    onClick={() => setViewMode('grid')}
                                    className={`px-4 py-2.5 transition-colors ${
                                        viewMode === 'grid'
                                            ? isDarkMode
                                                ? 'bg-indigo-600 text-white'
                                                : 'bg-indigo-600 text-white'
                                            : isDarkMode
                                                ? 'bg-gray-700 text-gray-400 hover:bg-gray-600'
                                                : 'bg-white text-gray-600 hover:bg-gray-50'
                                    }`}
                                    title="Grid View"
                                >
                                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM13 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z" />
                                    </svg>
                                </button>
                                <button
                                    onClick={() => setViewMode('list')}
                                    className={`px-4 py-2.5 transition-colors ${
                                        viewMode === 'list'
                                            ? isDarkMode
                                                ? 'bg-indigo-600 text-white'
                                                : 'bg-indigo-600 text-white'
                                            : isDarkMode
                                                ? 'bg-gray-700 text-gray-400 hover:bg-gray-600'
                                                : 'bg-white text-gray-600 hover:bg-gray-50'
                                    }`}
                                    title="List View"
                                >
                                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fillRule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clipRule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            {/* Results Count */}
                            <div className={`text-sm font-medium ${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                                <span className="font-bold text-indigo-600">{blogs.length}</span> {blogs.length === 1 ? 'article' : 'articles'} found
                            </div>
                        </div>
                    </div>

                    {/* Category Filter */}
                    <div className="flex flex-wrap gap-3">
                        {categories.map((category) => {
                            // Use dynamic count from category object
                            const count = category.blogs_count || 0;
                            
                            return (
                                <button
                                    key={category.id}
                                    onClick={() => handleCategoryChange(category.name)}
                                    className={`px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-200 ${
                                        selectedCategory === category.name
                                            ? isDarkMode
                                                ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/50'
                                                : 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30'
                                            : isDarkMode
                                                ? 'bg-gray-700 text-gray-300 hover:bg-gray-600 hover:scale-105'
                                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200 hover:scale-105'
                                    }`}
                                >
                                    {category.name}
                                    <span className={`ml-2 px-2 py-0.5 rounded-full text-xs font-semibold ${
                                        selectedCategory === category.name
                                            ? 'bg-white/20'
                                            : isDarkMode
                                                ? 'bg-gray-600'
                                                : 'bg-gray-200'
                                    }`}>
                                        {count}
                                    </span>
                                </button>
                            );
                        })}
                    </div>
                </div>
            </section>

            {/* Main Content with Sidebar */}
            <section className={`py-16 px-4 sm:px-6 lg:px-8 ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto">
                    <div className="grid grid-cols-1 lg:grid-cols-4 gap-8">
                        {/* Main Blog Posts Column */}
                        <div className="lg:col-span-3">
                            {blogs.length === 0 ? (
                                <div className="text-center py-20">
                                    <div className={`inline-flex items-center justify-center w-24 h-24 rounded-full mb-6 ${
                                        isDarkMode ? 'bg-gray-800' : 'bg-white'
                                    } shadow-lg`}>
                                        <svg className="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <h3 className={`text-3xl font-bold mb-3 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                        No articles found
                                    </h3>
                                    <p className={`text-lg mb-6 ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                                        {searchTerm || selectedCategory !== 'All' 
                                            ? `We couldn't find any articles matching "${searchTerm || selectedCategory}". Try adjusting your search terms or category filter.`
                                            : 'No articles available at the moment. Check back soon!'
                                        }
                                    </p>
                                    {(searchTerm || selectedCategory !== 'All') && (
                                        <button
                                            onClick={() => {
                                                setSearchTerm('');
                                                setSelectedCategory('All');
                                            }}
                                            className={`px-6 py-3 rounded-lg font-semibold transition-all duration-300 ${
                                                isDarkMode
                                                    ? 'bg-indigo-600 hover:bg-indigo-700 text-white'
                                                    : 'bg-indigo-600 hover:bg-indigo-700 text-white'
                                            }`}
                                        >
                                            Clear Filters
                                        </button>
                                    )}
                                </div>
                            ) : (
                                <div className={viewMode === 'grid' ? 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6' : 'space-y-6'}>
                                    {blogs.map((blog, index) => (
                                        <article 
                                            key={blog.id} 
                                            className={`${isDarkMode ? 'bg-gray-800' : 'bg-white'} rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden group cursor-pointer border ${isDarkMode ? 'border-gray-700' : 'border-gray-200'} hover:scale-[1.02] ${viewMode === 'list' ? 'flex flex-row' : 'flex flex-col'}`}
                                            style={{
                                                animationDelay: `${index * 100}ms`,
                                                animation: 'fadeInUp 0.6s ease-out forwards'
                                            }}
                                        >
                                            <div className={`bg-gradient-to-br ${getCategoryColor(blog.category)} relative overflow-hidden ${viewMode === 'list' ? 'w-64 flex-shrink-0' : 'h-48'}`}>
                                                {blog.featured_image && (
                                                    <img 
                                                        src={blog.featured_image} 
                                                        alt={blog.featured_image_alt || blog.title}
                                                        className="w-full h-full object-cover"
                                                    />
                                                )}
                                                <div className="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-all duration-500"></div>
                                                <div className="absolute top-3 left-3">
                                                    <span className={`px-2 py-1 rounded-full text-xs font-medium backdrop-blur-sm ${isDarkMode ? 'bg-gray-800/80 text-white' : 'bg-white/90 text-gray-900'}`}>
                                                        {blog.category || 'Uncategorized'}
                                                    </span>
                                                </div>
                                                <div className="absolute bottom-3 right-3 flex items-center space-x-2">
                                                    <div className={`flex items-center space-x-1 px-2 py-1 rounded-full backdrop-blur-sm ${isDarkMode ? 'bg-gray-800/80 text-white' : 'bg-white/90 text-gray-900'}`}>
                                                        <svg className="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.834a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                        </svg>
                                                        <span className="text-xs">{blog.likes_count || 0}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="p-4 flex-1 flex flex-col">
                                                <div className={`flex items-center text-xs mb-2 ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                                                    <span>{blog.publish_date}</span>
                                                    <span className="mx-1">•</span>
                                                    <span>{blog.reading_time}</span>
                                                </div>
                                                <h3 className={`${viewMode === 'list' ? 'text-xl' : 'text-base'} font-bold transition-all duration-300 mb-2 group-hover:text-indigo-500 line-clamp-2 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                                    {blog.title}
                                                </h3>
                                                <p className={`mb-3 leading-relaxed ${viewMode === 'list' ? 'text-sm' : 'text-xs'} ${viewMode === 'list' ? 'line-clamp-2' : 'line-clamp-3'} flex-1 ${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                                                    {blog.excerpt}
                                                </p>
                                                
                                                {/* Tags */}
                                                {blog.tags && blog.tags.length > 0 && (
                                                    <div className="flex flex-wrap gap-1.5 mb-3">
                                                        {blog.tags.slice(0, viewMode === 'list' ? 3 : 2).map((tag, tagIndex) => (
                                                            <span 
                                                                key={tagIndex}
                                                                className={`px-1.5 py-0.5 rounded-full text-xs font-medium ${
                                                                    isDarkMode 
                                                                        ? 'bg-gray-700 text-gray-300' 
                                                                        : 'bg-gray-100 text-gray-600'
                                                                }`}
                                                            >
                                                                {tag.name}
                                                            </span>
                                                        ))}
                                                    </div>
                                                )}

                                                {/* Actions */}
                                                <div className={`flex items-center justify-between mt-auto pt-3 border-t ${isDarkMode ? 'border-gray-700' : 'border-gray-200'}`}>
                                                    <div className="flex items-center space-x-3">
                                                        <div className={`flex items-center space-x-1 ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                                                            <svg className="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.834a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                            </svg>
                                                            <span className="text-xs">{blog.likes_count || 0}</span>
                                                        </div>
                                                        <div className={`flex items-center space-x-1 ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                                                            <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                            </svg>
                                                            <span className="text-xs">{blog.comments_count || 0}</span>
                                                        </div>
                                                    </div>
                                                    <a 
                                                        href={`/blog/${blog.slug}`}
                                                        className={`text-sm font-semibold flex items-center group transition-all duration-300 ${isDarkMode ? 'text-indigo-400 hover:text-indigo-300' : 'text-indigo-600 hover:text-indigo-700'}`}
                                                    >
                                                        Read More
                                                        <svg className="ml-1 h-3.5 w-3.5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </article>
                                    ))}
                                </div>
                            )}
                        </div>

                        {/* Sidebar */}
                        <div className="lg:col-span-1">
                            <div className="space-y-6">
                                {/* Categories - Tutorials Style */}
                                {categories.length > 1 && (
                                    <div className={`${isDarkMode ? 'bg-gray-800' : 'bg-white'} rounded-xl shadow-lg border ${isDarkMode ? 'border-gray-700' : 'border-gray-200'} overflow-hidden`}>
                                        <div className={`px-6 py-4 ${isDarkMode ? 'bg-indigo-600' : 'bg-indigo-600'}`}>
                                            <h3 className={`text-lg font-bold ${isDarkMode ? 'text-white' : 'text-white'}`}>
                                                Categories
                                            </h3>
                                        </div>
                                        <div className="p-4 space-y-2">
                                            {categories.filter(cat => cat.name !== 'All').map((category) => {
                                                const isSelected = selectedCategory === category.name;
                                                return (
                                                    <button
                                                        key={category.id}
                                                        onClick={() => handleCategoryChange(category.name)}
                                                        className={`w-full text-left px-4 py-3 rounded-lg transition-all duration-200 flex items-center justify-between group ${
                                                            isSelected
                                                                ? isDarkMode
                                                                    ? 'bg-indigo-600 text-white shadow-md'
                                                                    : 'bg-indigo-600 text-white shadow-md'
                                                                : isDarkMode
                                                                    ? 'bg-gray-700/50 text-gray-300 hover:bg-gray-700'
                                                                    : 'bg-gray-50 text-gray-700 hover:bg-gray-100'
                                                        }`}
                                                    >
                                                        <span className="text-sm font-medium">{category.name}</span>
                                                        <span className={`text-xs px-2.5 py-1 rounded-full font-semibold ${
                                                            isSelected
                                                                ? 'bg-white/20 text-white'
                                                                : isDarkMode
                                                                    ? 'bg-gray-600 text-gray-300'
                                                                    : 'bg-gray-200 text-gray-600'
                                                        }`}>
                                                            {category.blogs_count || 0}
                                                        </span>
                                                    </button>
                                                );
                                            })}
                                        </div>
                                    </div>
                                )}

                                {/* Popular Posts */}
                                {popularBlogs.length > 0 && (
                                    <div className={`${isDarkMode ? 'bg-gray-800' : 'bg-white'} rounded-xl shadow-lg p-6 border ${isDarkMode ? 'border-gray-700' : 'border-gray-200'}`}>
                                        <h3 className={`text-lg font-bold mb-4 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                            Popular Posts
                                        </h3>
                                        <div className="space-y-4">
                                            {popularBlogs.slice(0, 5).map((blog) => (
                                                <a 
                                                    key={blog.id}
                                                    href={`/blog/${blog.slug}`}
                                                    className="block group"
                                                >
                                                    <div className="flex gap-3">
                                                        {blog.featured_image ? (
                                                            <img 
                                                                src={blog.featured_image} 
                                                                alt={blog.title}
                                                                className="w-16 h-16 rounded-lg object-cover flex-shrink-0 group-hover:scale-105 transition-transform duration-300"
                                                            />
                                                        ) : (
                                                            <div className={`w-16 h-16 rounded-lg flex-shrink-0 ${getCategoryColor(blog.category)}`}>
                                                            </div>
                                                        )}
                                                        <div className="flex-1 min-w-0">
                                                            <h4 className={`text-sm font-semibold mb-1 line-clamp-2 group-hover:text-indigo-500 transition-colors ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                                                {blog.title}
                                                            </h4>
                                                            <p className={`text-xs ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                                                                {blog.publish_date}
                                                            </p>
                                                            {blog.views_count > 0 && (
                                                                <div className={`flex items-center gap-1 mt-1 text-xs ${isDarkMode ? 'text-gray-500' : 'text-gray-400'}`}>
                                                                    <svg className="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                    </svg>
                                                                    <span>{blog.views_count}</span>
                                                                </div>
                                                            )}
                                                        </div>
                                                    </div>
                                                </a>
                                            ))}
                                        </div>
                                    </div>
                                )}

                                {/* Recent Posts */}
                                {recentBlogs.length > 0 && (
                                    <div className={`${isDarkMode ? 'bg-gray-800' : 'bg-white'} rounded-xl shadow-lg p-6 border ${isDarkMode ? 'border-gray-700' : 'border-gray-200'}`}>
                                        <h3 className={`text-lg font-bold mb-4 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                            Recent Posts
                                        </h3>
                                        <div className="space-y-3">
                                            {recentBlogs.slice(0, 5).map((blog) => (
                                                <a 
                                                    key={blog.id}
                                                    href={`/blog/${blog.slug}`}
                                                    className="block group"
                                                >
                                                    <div>
                                                        <h4 className={`text-sm font-semibold mb-1 line-clamp-2 group-hover:text-indigo-500 transition-colors ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                                            {blog.title}
                                                        </h4>
                                                        <p className={`text-xs ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                                                            {blog.publish_date}
                                                        </p>
                                                    </div>
                                                </a>
                                            ))}
                                        </div>
                                    </div>
                                )}

                                {/* Popular Tags */}
                                {popularTags.length > 0 && (
                                    <div className={`${isDarkMode ? 'bg-gray-800' : 'bg-white'} rounded-2xl shadow-lg p-6 border ${isDarkMode ? 'border-gray-700' : 'border-gray-200'}`}>
                                        <h3 className={`text-xl font-bold mb-6 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                            Popular Tags
                                        </h3>
                                        <div className="flex flex-wrap gap-2">
                                            {popularTags.map((tag) => (
                                                <button
                                                    key={tag.id}
                                                    onClick={() => handleTagClick(tag.name)}
                                                    className={`px-3 py-1.5 rounded-full text-xs font-medium transition-all duration-200 hover:scale-105 ${
                                                        searchTerm.toLowerCase() === tag.name.toLowerCase()
                                                            ? isDarkMode
                                                                ? 'bg-indigo-600 text-white'
                                                                : 'bg-indigo-600 text-white'
                                                            : isDarkMode
                                                                ? 'bg-gray-700 text-gray-300 hover:bg-gray-600'
                                                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                                                    }`}
                                                >
                                                    {tag.name}
                                                    {tag.blogs_count > 0 && (
                                                        <span className="ml-1 opacity-75">({tag.blogs_count})</span>
                                                    )}
                                                </button>
                                            ))}
                                        </div>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
};

export default Blog;
