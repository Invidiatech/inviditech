import React, { useState, useEffect } from 'react';

const BlogDetail = ({ isDarkMode, currentBlog }) => {
    const [isLiked, setIsLiked] = useState(false);
    const [likeCount, setLikeCount] = useState(0);
    const [isPlaying, setIsPlaying] = useState(false);
    const [currentTime, setCurrentTime] = useState(0);
    const [duration, setDuration] = useState(0);
    const [comments, setComments] = useState([]);
    const [newCommentAuthor, setNewCommentAuthor] = useState('');
    const [newComment, setNewComment] = useState('');
    const [showShareMenu, setShowShareMenu] = useState(false);

    // Initialize data from props
    useEffect(() => {
        if (currentBlog) {
            setLikeCount(currentBlog.likes_count || 0);

            const storageKey = `blog-comments-${currentBlog.id || 'default'}`;
            const storedComments = localStorage.getItem(storageKey);

            if (storedComments) {
                try {
                    setComments(JSON.parse(storedComments));
                } catch (error) {
                    console.error('Failed to parse stored comments:', error);
                    setComments([]);
                }
            } else {
                setComments([]);
            }
        }
    }, [currentBlog]);

    useEffect(() => {
        if (currentBlog) {
            const storageKey = `blog-comments-${currentBlog.id || 'default'}`;
            localStorage.setItem(storageKey, JSON.stringify(comments));
        }
    }, [comments, currentBlog]);

    // Add copy functionality to code blocks
    useEffect(() => {
        if (currentBlog && currentBlog.content) {
            setTimeout(() => {
                addCopyButtonsToCodeBlocks();
            }, 100);
        }
    }, [currentBlog]);

    // Function to add copy buttons only to code blocks
    const addCopyButtonsToCodeBlocks = () => {
        const codeBlocks = document.querySelectorAll('pre.ql-syntax');
        codeBlocks.forEach((codeBlock) => {
            if (!codeBlock.querySelector('.copy-button')) {
                const copyButton = document.createElement('button');
                copyButton.className = 'copy-button';
                copyButton.textContent = 'Copy';
                copyButton.onclick = () => copyCode(codeBlock.textContent);
                codeBlock.style.position = 'relative';
                codeBlock.appendChild(copyButton);
            }
        });
    };

    // Function to copy code to clipboard
    const copyCode = async (text) => {
        try {
            await navigator.clipboard.writeText(text);
            // Show success feedback
            const event = new CustomEvent('copy-success');
            window.dispatchEvent(event);
        } catch (err) {
            console.error('Failed to copy code:', err);
        }
    };

    // If no blog data, show not found
    if (!currentBlog) {
        return (
            <div className={`min-h-screen flex items-center justify-center ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="text-center">
                    <div className="text-6xl mb-4">😞</div>
                    <h3 className={`text-2xl font-bold mb-4 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                        Blog Post Not Found
                    </h3>
                    <p className={`${isDarkMode ? 'text-gray-400' : 'text-gray-600'} mb-6`}>
                        The blog post you're looking for doesn't exist or has been removed.
                    </p>
                    <a
                        href="/blog"
                        className={`px-6 py-3 rounded-lg font-semibold transition-all duration-200 ${
                            isDarkMode 
                                ? 'bg-indigo-600 hover:bg-indigo-700 text-white' 
                                : 'bg-indigo-600 hover:bg-indigo-700 text-white'
                        }`}
                    >
                        Back to Blog
                    </a>
                </div>
            </div>
        );
    }

    const handleLike = () => {
        setIsLiked(!isLiked);
        setLikeCount(prev => isLiked ? prev - 1 : prev + 1);
    };

    const handlePlayPause = () => {
        setIsPlaying(!isPlaying);
    };

    const handleTimeUpdate = (e) => {
        setCurrentTime(e.target.currentTime);
    };

    const handleDurationChange = (e) => {
        setDuration(e.target.duration);
    };

    const formatTime = (time) => {
        const minutes = Math.floor(time / 60);
        const seconds = Math.floor(time % 60);
        return `${minutes}:${seconds.toString().padStart(2, '0')}`;
    };

    const handleCommentSubmit = (e) => {
        e.preventDefault();
        if (newComment.trim() && newCommentAuthor.trim()) {
            const displayName = newCommentAuthor.trim();
            const initials = displayName
                .split(' ')
                .filter(Boolean)
                .slice(0, 2)
                .map((part) => part[0]?.toUpperCase())
                .join('') || 'U';

            const comment = {
                id: Date.now(),
                author: displayName,
                avatar: initials,
                time: "just now",
                text: newComment,
                likes: 0
            };
            setComments([comment, ...comments]);
            setNewCommentAuthor('');
            setNewComment('');
        }
    };

    const handleShare = (platform) => {
        const url = window.location.href;
        const title = currentBlog.title;
        
        switch (platform) {
            case 'twitter':
                window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}`);
                break;
            case 'linkedin':
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`);
                break;
            case 'facebook':
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`);
                break;
            case 'copy':
                navigator.clipboard.writeText(url);
                alert('Link copied to clipboard!');
                break;
        }
        setShowShareMenu(false);
    };

    return (
        <div className={`min-h-screen ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
            {/* Hero Section */}
            <section className={`pt-10 pb-6 px-4 sm:px-8 lg:px-12 ${isDarkMode ? 'bg-gray-800' : 'bg-white'}`}>
                <div className="w-full">
                    {/* Breadcrumb */}
                    <nav className="mb-8">
                        <ol className="flex items-center space-x-2 text-sm">
                            <li><a href="/" className={`${isDarkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'}`}>Home</a></li>
                            <li className={`${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>/</li>
                            <li><a href="/blog" className={`${isDarkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'}`}>Blog</a></li>
                            <li className={`${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>/</li>
                            <li className={`${isDarkMode ? 'text-white' : 'text-gray-900'}`}>Article</li>
                        </ol>
                    </nav>

                    {/* Article Header */}
                    <div className="mb-2">
                        <div className={`inline-block px-3 py-1 rounded-full text-sm font-medium mb-4 ${
                            isDarkMode ? 'bg-indigo-900 text-indigo-300' : 'bg-indigo-100 text-indigo-800'
                        }`}>
                            {currentBlog.category}
                        </div>

                        {/* Article Meta */}
                        <div className="flex flex-wrap items-center justify-between gap-6 mb-3">
                            <div className="flex items-center">
                                <div className="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-3">
                                    MN
                                </div>
                                <div className="leading-snug">
                                    <div className={`font-semibold ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                        {currentBlog.author}
                                    </div>
                                    <div className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                                        {currentBlog.publish_date} • {currentBlog.reading_time}
                                    </div>
                                </div>
                            </div>
                            
                            {/* Action Buttons */}
                            <div className="flex items-center space-x-3">
                                <button
                                    onClick={handleLike}
                                    className={`flex items-center space-x-2 px-4 py-2 rounded-lg transition-all duration-200 ${
                                        isLiked
                                            ? isDarkMode
                                                ? 'bg-red-600 text-white'
                                                : 'bg-red-600 text-white'
                                            : isDarkMode
                                                ? 'bg-gray-700 text-gray-300 hover:bg-gray-600'
                                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                                    }`}
                                >
                                    <svg className={`w-5 h-5 ${isLiked ? 'fill-current' : ''}`} fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span>{likeCount}</span>
                                </button>
                                
                                <div className="relative">
                                    <button
                                        onClick={() => setShowShareMenu(!showShareMenu)}
                                        className={`flex items-center space-x-2 px-4 py-2 rounded-lg transition-all duration-200 ${
                                            isDarkMode
                                                ? 'bg-gray-700 text-gray-300 hover:bg-gray-600'
                                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                                        }`}
                                    >
                                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                                        </svg>
                                        <span>Share</span>
                                    </button>
                                    
                                    {showShareMenu && (
                                        <div className={`absolute top-full right-0 mt-2 w-48 rounded-lg shadow-lg border z-10 ${
                                            isDarkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'
                                        }`}>
                                            <div className="py-2">
                                                <button
                                                    onClick={() => handleShare('twitter')}
                                                    className={`w-full text-left px-4 py-2 text-sm hover:bg-gray-100 transition-colors duration-200 ${
                                                        isDarkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-700'
                                                    }`}
                                                >
                                                    Share on Twitter
                                                </button>
                                                <button
                                                    onClick={() => handleShare('linkedin')}
                                                    className={`w-full text-left px-4 py-2 text-sm hover:bg-gray-100 transition-colors duration-200 ${
                                                        isDarkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-700'
                                                    }`}
                                                >
                                                    Share on LinkedIn
                                                </button>
                                                <button
                                                    onClick={() => handleShare('facebook')}
                                                    className={`w-full text-left px-4 py-2 text-sm hover:bg-gray-100 transition-colors duration-200 ${
                                                        isDarkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-700'
                                                    }`}
                                                >
                                                    Share on Facebook
                                                </button>
                                                <button
                                                    onClick={() => handleShare('copy')}
                                                    className={`w-full text-left px-4 py-2 text-sm hover:bg-gray-100 transition-colors duration-200 ${
                                                        isDarkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-700'
                                                    }`}
                                                >
                                                    Copy Link
                                                </button>
                                            </div>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>

                        <h1 className={`text-4xl md:text-5xl lg:text-6xl font-bold mb-2 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                            {currentBlog.title}
                        </h1>
                        <p className={`text-xl md:text-2xl leading-snug mb-3 ${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                            {currentBlog.excerpt}
                        </p>
                        
                        {/* Tags */}
                        <div className="flex flex-wrap gap-2 mt-1">
                            {currentBlog.tags.map((tag, index) => (
                                <span 
                                    key={index}
                                    className={`px-3 py-1 rounded-full text-sm font-medium ${
                                        isDarkMode 
                                            ? 'bg-gray-700 text-gray-300' 
                                            : 'bg-gray-100 text-gray-600'
                                    }`}
                                >
                                    #{tag.name}
                                </span>
                            ))}
                        </div>
                    </div>
                </div>
            </section>

            {/* Voice Player Section */}
           {/*} <section className={`px-4 sm:px-6 lg:px-8 ${isDarkMode ? 'bg-gray-800' : 'bg-white'} border-b ${isDarkMode ? 'border-gray-700' : 'border-gray-200'}`}>
                <div className="max-w-4xl mx-auto">
                    <div className={`${isDarkMode ? 'bg-gray-700' : 'bg-gray-50'} rounded-2xl p-6`}>
                        <div className="flex items-center justify-between mb-4">
                            <h3 className={`text-lg font-semibold ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                🎧 Listen to this article
                            </h3>
                            <div className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                                {formatTime(currentTime)} / {formatTime(duration)}
                            </div>
                        </div>
                        
                        <div className="flex items-center space-x-4">
                            <button
                                onClick={handlePlayPause}
                                className={`w-12 h-12 rounded-full flex items-center justify-center transition-all duration-200 ${
                                    isPlaying
                                        ? isDarkMode
                                            ? 'bg-red-600 text-white'
                                            : 'bg-red-600 text-white'
                                        : isDarkMode
                                            ? 'bg-indigo-600 text-white hover:bg-indigo-700'
                                            : 'bg-indigo-600 text-white hover:bg-indigo-700'
                                }`}
                            >
                                {isPlaying ? (
                                    <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fillRule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 00-1 1v2a1 1 0 102 0V9a1 1 0 00-1-1zm4 0a1 1 0 00-1 1v2a1 1 0 102 0V9a1 1 0 00-1-1z" clipRule="evenodd" />
                                    </svg>
                                ) : (
                                    <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clipRule="evenodd" />
                                    </svg>
                                )}
                            </button>
                            
                            <div className="flex-1">
                                <div className={`w-full h-2 rounded-full ${isDarkMode ? 'bg-gray-600' : 'bg-gray-300'}`}>
                                    <div 
                                        className="h-2 bg-indigo-600 rounded-full transition-all duration-200"
                                        style={{ width: `${duration ? (currentTime / duration) * 100 : 0}%` }}
                                    ></div>
                                </div>
                            </div>
                            
                                <div className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                                    {currentBlog.reading_time}
                                </div>
                        </div>
                        
                        <audio
                            src="/audio/sample-article.mp3"
                            onTimeUpdate={handleTimeUpdate}
                            onDurationChange={handleDurationChange}
                            className="hidden"
                        />
                    </div>
                </div>
            </section> */}

            {/* Article Content */}
            <section className={`pt-2 pb-16 px-4 sm:px-8 lg:px-12 ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="w-full">
                    <div className={`${isDarkMode ? 'bg-gray-800/80 border border-gray-700' : 'bg-white border border-gray-100'} rounded-2xl p-8 shadow-sm`}>
                            <div 
                                className={`blog-reading prose prose-lg max-w-none ${
                                    isDarkMode 
                                        ? 'prose-invert prose-headings:text-white prose-p:text-gray-300 prose-strong:text-white prose-code:text-indigo-400 prose-pre:bg-gray-900' 
                                        : 'prose-headings:text-gray-900 prose-p:text-gray-600 prose-strong:text-gray-900 prose-code:text-indigo-600 prose-pre:bg-gray-100'
                                }`}
                                dangerouslySetInnerHTML={{ __html: currentBlog.content }}
                            />
                    </div>
                </div>
            </section>

            {/* Comments Section */}
            <section className={`py-16 px-4 sm:px-8 lg:px-12 ${isDarkMode ? 'bg-gray-800' : 'bg-white'}`}>
                <div className="w-full">
                    <h2 className={`text-3xl font-bold mb-8 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                        Comments ({comments.length})
                    </h2>
                    
                    {/* Add Comment Form */}
                    <form onSubmit={handleCommentSubmit} className="mb-12">
                        <div className={`${isDarkMode ? 'bg-gray-700' : 'bg-gray-50'} rounded-2xl p-6`}>
                            <div className="flex items-start space-x-4">
                                <div className="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                    {newCommentAuthor.trim() ? newCommentAuthor.trim().slice(0, 2).toUpperCase() : 'Y'}
                                </div>
                                <div className="flex-1">
                                    <input
                                        type="text"
                                        value={newCommentAuthor}
                                        onChange={(e) => setNewCommentAuthor(e.target.value)}
                                        placeholder="Your name"
                                        className={`w-full mb-3 p-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-200 ${
                                            isDarkMode 
                                                ? 'bg-gray-600 border-gray-500 text-white placeholder-gray-400' 
                                                : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500'
                                        }`}
                                    />
                                    <textarea
                                        value={newComment}
                                        onChange={(e) => setNewComment(e.target.value)}
                                        placeholder="Share your thoughts..."
                                        rows={4}
                                        className={`w-full p-4 rounded-lg border resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-200 ${
                                            isDarkMode 
                                                ? 'bg-gray-600 border-gray-500 text-white placeholder-gray-400' 
                                                : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500'
                                        }`}
                                    />
                                    <div className="flex justify-end mt-4">
                                        <button
                                            type="submit"
                                            disabled={!newComment.trim() || !newCommentAuthor.trim()}
                                            className={`px-6 py-2 rounded-lg font-semibold transition-all duration-200 ${
                                                newComment.trim() && newCommentAuthor.trim()
                                                    ? 'bg-indigo-600 text-white hover:bg-indigo-700'
                                                    : isDarkMode
                                                        ? 'bg-gray-600 text-gray-400 cursor-not-allowed'
                                                        : 'bg-gray-200 text-gray-400 cursor-not-allowed'
                                            }`}
                                        >
                                            Post Comment
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    {/* Comments List */}
                    <div className="space-y-6">
                        {comments.map((comment) => (
                            <div key={comment.id} className={`${isDarkMode ? 'bg-gray-700' : 'bg-gray-50'} rounded-2xl p-6`}>
                                <div className="flex items-start space-x-4">
                                    <div className="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {comment.avatar}
                                    </div>
                                    <div className="flex-1">
                                        <div className="flex items-center justify-between mb-2">
                                            <div className="flex items-center space-x-2">
                                                <h4 className={`font-semibold ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                                    {comment.author}
                                                </h4>
                                                <span className={`text-sm ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                                                    {comment.time}
                                                </span>
                                            </div>
                                            <button className={`flex items-center space-x-1 px-2 py-1 rounded-lg transition-colors duration-200 ${
                                                isDarkMode 
                                                    ? 'text-gray-400 hover:text-gray-300 hover:bg-gray-600' 
                                                    : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200'
                                            }`}>
                                                <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.834a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                </svg>
                                                <span className="text-sm">{comment.likes}</span>
                                            </button>
                                        </div>
                                        <p className={`${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                                            {comment.text}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        </div>
    );
};

export default BlogDetail;
