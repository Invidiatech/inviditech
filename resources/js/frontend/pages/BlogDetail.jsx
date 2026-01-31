import React, { useState, useEffect, useRef } from 'react';

const BlogDetail = ({ isDarkMode, currentBlog }) => {
    // State management
    const [isLiked, setIsLiked] = useState(false);
    const [likeCount, setLikeCount] = useState(0);
    const [isBookmarked, setIsBookmarked] = useState(false);
    const [comments, setComments] = useState([]);
    const [newCommentAuthor, setNewCommentAuthor] = useState('');
    const [newComment, setNewComment] = useState('');
    const [showShareMenu, setShowShareMenu] = useState(false);
    
    // New enhanced features state
    const [readingProgress, setReadingProgress] = useState(0);
    const [fontSize, setFontSize] = useState('medium');
    const [showBackToTop, setShowBackToTop] = useState(false);
    const [timeRemaining, setTimeRemaining] = useState(0);
    const [selectedText, setSelectedText] = useState('');
    const [showHighlightMenu, setShowHighlightMenu] = useState(false);
    const [highlightMenuPosition, setHighlightMenuPosition] = useState({ x: 0, y: 0 });
    const [isSpeaking, setIsSpeaking] = useState(false);
    const [isPaused, setIsPaused] = useState(false);
    const [showImageModal, setShowImageModal] = useState(false);
    const [modalImageSrc, setModalImageSrc] = useState('');
    const [reactions, setReactions] = useState({
        helpful: false,
        love: false,
        insightful: false,
        bookmark: false
    });
    const [tocItems, setTocItems] = useState([]);
    const [activeTocId, setActiveTocId] = useState('');
    const [showToc, setShowToc] = useState(true);
    
    // Text-to-speech controls
    const [voices, setVoices] = useState([]);
    const [selectedVoice, setSelectedVoice] = useState(null);
    const [speechRate, setSpeechRate] = useState(1.0);
    const [showSpeechControls, setShowSpeechControls] = useState(false);
    
    const articleRef = useRef(null);
    const speechSynthesisRef = useRef(null);

    // Initialize data from props and localStorage
    useEffect(() => {
        if (currentBlog) {
            setLikeCount(currentBlog.likes_count || 0);
            
            // Load saved reading position
            const savedPosition = localStorage.getItem(`reading_position_${currentBlog.id}`);
            if (savedPosition && parseInt(savedPosition) > 500) {
                setTimeout(() => {
                    if (window.confirm('Continue from where you left off?')) {
                        window.scrollTo({ top: parseInt(savedPosition), behavior: 'smooth' });
                    } else {
                        localStorage.removeItem(`reading_position_${currentBlog.id}`);
                    }
                }, 1000);
            }
            
            // Load comments
            const storageKey = `blog-comments-${currentBlog.id || 'default'}`;
            const storedComments = localStorage.getItem(storageKey);
            if (storedComments) {
                try {
                    setComments(JSON.parse(storedComments));
                } catch (error) {
                    console.error('Failed to parse stored comments:', error);
                    setComments([]);
                }
            }
            
            // Load reactions
            const savedReactions = JSON.parse(localStorage.getItem(`reactions_${currentBlog.id}`) || '{}');
            setReactions(prev => ({ ...prev, ...savedReactions }));
            
            // Load font size
            const savedFontSize = localStorage.getItem('articleFontSize') || 'medium';
            setFontSize(savedFontSize);
            
            // Load speech rate
            const savedRate = localStorage.getItem('speechRate') || '1.0';
            setSpeechRate(parseFloat(savedRate));
        }
    }, [currentBlog]);

    // Load available voices for text-to-speech
    useEffect(() => {
        const loadVoices = () => {
            const availableVoices = window.speechSynthesis.getVoices();
            console.log('Available voices:', availableVoices.length);
            console.log('Voices:', availableVoices.map(v => `${v.name} (${v.lang})`));
            
            if (availableVoices.length > 0) {
                setVoices(availableVoices);
                
                // Select default English voice
                const defaultVoice = availableVoices.find(v => v.lang.startsWith('en-US')) || 
                                   availableVoices.find(v => v.lang.startsWith('en')) || 
                                   availableVoices[0];
                
                const savedVoiceURI = localStorage.getItem('selectedVoiceURI');
                
                if (savedVoiceURI) {
                    const savedVoice = availableVoices.find(v => v.voiceURI === savedVoiceURI);
                    if (savedVoice) {
                        setSelectedVoice(savedVoice);
                        console.log('Loaded saved voice:', savedVoice.name);
                    } else {
                        setSelectedVoice(defaultVoice);
                        console.log('Saved voice not found, using default:', defaultVoice?.name);
                    }
                } else {
                    setSelectedVoice(defaultVoice);
                    console.log('Using default voice:', defaultVoice?.name);
                }
            }
        };
        
        // Load voices immediately
        loadVoices();
        
        // Some browsers load voices asynchronously
        if (window.speechSynthesis.onvoiceschanged !== undefined) {
            window.speechSynthesis.onvoiceschanged = loadVoices;
        }
        
        // Also try loading after a short delay
        setTimeout(loadVoices, 100);
        setTimeout(loadVoices, 500);
        
        return () => {
            if (window.speechSynthesis.onvoiceschanged !== undefined) {
                window.speechSynthesis.onvoiceschanged = null;
            }
        };
    }, []);

    // Save comments to localStorage
    useEffect(() => {
        if (currentBlog) {
            const storageKey = `blog-comments-${currentBlog.id || 'default'}`;
            localStorage.setItem(storageKey, JSON.stringify(comments));
        }
    }, [comments, currentBlog]);

    // Generate Table of Contents
    useEffect(() => {
        if (currentBlog && currentBlog.content && articleRef.current) {
            setTimeout(() => {
                const headings = articleRef.current.querySelectorAll('h1, h2, h3, h4, h5, h6');
                const tocData = [];
                
                console.log('Found headings:', headings.length);
                
                headings.forEach((heading, index) => {
                    const id = heading.id || `heading-${index}`;
                    if (!heading.id) {
                        heading.id = id;
                        heading.style.scrollMarginTop = '120px'; // For smooth scroll offset
                    }
                    
                    const text = heading.textContent.trim();
                    if (text) { // Only add if heading has text
                        tocData.push({
                            id,
                            text,
                            level: parseInt(heading.tagName.charAt(1))
                        });
                        console.log(`Added TOC item: ${text} (${heading.tagName})`);
                    }
                });
                
                console.log('TOC items:', tocData);
                setTocItems(tocData);
                addCopyButtonsToCodeBlocks();
                setupImageZoom();
            }, 500); // Increased delay to ensure content is fully rendered
        }
    }, [currentBlog]);

    // Reading progress tracker
    useEffect(() => {
        const handleScroll = () => {
            if (articleRef.current) {
                const articleStart = articleRef.current.offsetTop;
                const articleHeight = articleRef.current.offsetHeight;
                const windowHeight = window.innerHeight;
                const scrollTop = window.pageYOffset;
                
                // Progress calculation
                const articleEnd = articleStart + articleHeight - windowHeight;
                const progress = Math.max(0, Math.min(100, ((scrollTop - articleStart + 100) / (articleEnd - articleStart + 100)) * 100));
                setReadingProgress(progress);
                
                // Back to top button
                setShowBackToTop(scrollTop > 300);
                
                // Time remaining calculation
                if (currentBlog && scrollTop > articleStart - 100) {
                    const readingSpeed = 200; // words per minute
                    const totalWords = articleRef.current.textContent.split(/\s+/).length;
                    const totalMinutes = Math.ceil(totalWords / readingSpeed);
                    const progressPercent = (scrollTop - articleStart + windowHeight) / articleHeight;
                    const minutesLeft = Math.max(0, Math.ceil(totalMinutes * (1 - progressPercent)));
                    setTimeRemaining(minutesLeft);
                }
                
                // Save reading position
                if (currentBlog) {
                    localStorage.setItem(`reading_position_${currentBlog.id}`, scrollTop.toString());
                }
                
                // Active TOC tracking
                const headings = articleRef.current.querySelectorAll('h1, h2, h3, h4, h5, h6');
                headings.forEach(heading => {
                    const rect = heading.getBoundingClientRect();
                    if (rect.top <= 150 && rect.bottom >= 150) {
                        setActiveTocId(heading.id);
                    }
                });
            }
        };
        
        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, [currentBlog]);

    // Text selection for highlight-to-share
    useEffect(() => {
        const handleMouseUp = () => {
            setTimeout(() => {
                const selection = window.getSelection();
                const text = selection.toString().trim();
                
                if (text.length > 10 && articleRef.current?.contains(selection.anchorNode)) {
                    setSelectedText(text);
                    const range = selection.getRangeAt(0);
                    const rect = range.getBoundingClientRect();
                    setHighlightMenuPosition({
                        x: rect.left + (rect.width / 2),
                        y: rect.top + window.scrollY - 50
                    });
                    setShowHighlightMenu(true);
                } else {
                    setShowHighlightMenu(false);
                }
            }, 10);
        };
        
        const handleMouseDown = (e) => {
            if (showHighlightMenu && !e.target.closest('.highlight-menu')) {
                setShowHighlightMenu(false);
            }
        };
        
        document.addEventListener('mouseup', handleMouseUp);
        document.addEventListener('mousedown', handleMouseDown);
        
        return () => {
            document.removeEventListener('mouseup', handleMouseUp);
            document.removeEventListener('mousedown', handleMouseDown);
        };
    }, [showHighlightMenu]);

    // Add copy buttons to code blocks
    const addCopyButtonsToCodeBlocks = () => {
        const codeBlocks = articleRef.current?.querySelectorAll('pre.ql-syntax');
        codeBlocks?.forEach((codeBlock) => {
            if (!codeBlock.querySelector('.copy-button')) {
                const copyButton = document.createElement('button');
                copyButton.className = 'copy-button';
                copyButton.textContent = 'Copy';
                copyButton.onclick = () => copyCode(codeBlock.textContent, copyButton);
                codeBlock.style.position = 'relative';
                codeBlock.appendChild(copyButton);
            }
        });
    };

    // Setup image zoom
    const setupImageZoom = () => {
        const images = articleRef.current?.querySelectorAll('img');
        images?.forEach(img => {
            img.style.cursor = 'zoom-in';
            img.onclick = () => {
                setModalImageSrc(img.src);
                setShowImageModal(true);
            };
        });
    };

    // Copy code to clipboard
    const copyCode = async (text, button) => {
        try {
            await navigator.clipboard.writeText(text);
            const originalText = button.textContent;
            button.textContent = 'Copied!';
            button.style.background = 'rgba(34, 197, 94, 0.9)';
            setTimeout(() => {
                button.textContent = originalText;
                button.style.background = '';
            }, 2000);
            showNotification('Code copied to clipboard!');
        } catch (err) {
            console.error('Failed to copy code:', err);
        }
    };

    // Handle font size change
    const handleFontSizeChange = (size) => {
        setFontSize(size);
        localStorage.setItem('articleFontSize', size);
    };

    // Handle text-to-speech
    const toggleTextToSpeech = () => {
        if (!isSpeaking && !isPaused) {
            // Start speaking
            try {
                // Get clean text from article (remove HTML, keep only text)
                let text = '';
                if (articleRef.current) {
                    // Clone the node to avoid modifying the original
                    const clone = articleRef.current.cloneNode(true);
                    
                    // Remove code blocks (they're usually not useful to read)
                    clone.querySelectorAll('pre, code').forEach(el => el.remove());
                    
                    // Get text content
                    text = clone.textContent || clone.innerText || '';
                    
                    // Clean up extra whitespace
                    text = text.replace(/\s+/g, ' ').trim();
                }
                
                if (!text || text.length < 10) {
                    showNotification('❌ No text to read');
                    return;
                }
                
                console.log('Text to speak:', text.substring(0, 100) + '...');
                console.log('Text length:', text.length);
                console.log('Selected voice:', selectedVoice);
                console.log('Speech rate:', speechRate);
                
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.rate = speechRate;
                utterance.pitch = 1.0;
                utterance.volume = 1.0;
                
                if (selectedVoice) {
                    utterance.voice = selectedVoice;
                    console.log('Using voice:', selectedVoice.name);
                }
                
                utterance.onstart = () => {
                    console.log('Speech started');
                    setIsSpeaking(true);
                    setIsPaused(false);
                };
                
                utterance.onend = () => {
                    console.log('Speech ended');
                    setIsSpeaking(false);
                    setIsPaused(false);
                };
                
                utterance.onerror = (event) => {
                    console.error('Speech error:', event);
                    showNotification('❌ Audio playback error: ' + event.error);
                    setIsSpeaking(false);
                    setIsPaused(false);
                };
                
                utterance.onpause = () => {
                    console.log('Speech paused');
                };
                
                utterance.onresume = () => {
                    console.log('Speech resumed');
                };
                
                speechSynthesisRef.current = utterance;
                
                // Cancel any existing speech first
                window.speechSynthesis.cancel();
                
                // Small delay to ensure cancel completes
                setTimeout(() => {
                    window.speechSynthesis.speak(utterance);
                    console.log('Speech command sent');
                    showNotification('🔊 Playing article audio...');
                }, 100);
                
            } catch (error) {
                console.error('Error starting speech:', error);
                showNotification('❌ Failed to start audio: ' + error.message);
            }
        } else if (isSpeaking && !isPaused) {
            // Pause
            window.speechSynthesis.pause();
            setIsPaused(true);
            showNotification('⏸️ Audio paused');
        } else if (isPaused) {
            // Resume
            window.speechSynthesis.resume();
            setIsPaused(false);
            showNotification('▶️ Audio resumed');
        }
    };
    
    const stopTextToSpeech = () => {
        window.speechSynthesis.cancel();
        setIsSpeaking(false);
        setIsPaused(false);
        showNotification('⏹️ Audio stopped');
    };
    
    const handleVoiceChange = (voiceURI) => {
        const voice = voices.find(v => v.voiceURI === voiceURI);
        setSelectedVoice(voice);
        localStorage.setItem('selectedVoiceURI', voiceURI);
        console.log('Voice changed to:', voice?.name);
        
        // If currently speaking, restart with new voice
        if (isSpeaking) {
            stopTextToSpeech();
            setTimeout(() => {
                toggleTextToSpeech();
            }, 200);
        }
    };
    
    const handleSpeedChange = (rate) => {
        setSpeechRate(rate);
        localStorage.setItem('speechRate', rate.toString());
        console.log('Speed changed to:', rate);
        
        // If currently speaking, restart with new speed
        if (isSpeaking) {
            const wasPaused = isPaused;
            stopTextToSpeech();
            if (!wasPaused) {
                setTimeout(() => {
                    toggleTextToSpeech();
                }, 200);
            }
        }
    };

    // Handle reactions
    const handleReaction = (reactionType) => {
        setReactions(prev => {
            const newReactions = { ...prev, [reactionType]: !prev[reactionType] };
            localStorage.setItem(`reactions_${currentBlog.id}`, JSON.stringify(newReactions));
            return newReactions;
        });
    };

    // Handle TOC click
    const handleTocClick = (id) => {
        console.log('TOC clicked:', id);
        const element = document.getElementById(id);
        console.log('Element found:', element);
        
        if (element) {
            // Get element position
            const elementPosition = element.getBoundingClientRect().top + window.pageYOffset;
            const offsetPosition = elementPosition - 120; // Account for fixed header
            
            console.log('Scrolling to:', offsetPosition);
            
            // Scroll to element
            window.scrollTo({ 
                top: offsetPosition, 
                behavior: 'smooth' 
            });
            
            // Highlight heading
            document.querySelectorAll('.heading-highlighted').forEach(el => {
                el.classList.remove('heading-highlighted');
            });
            element.classList.add('heading-highlighted');
            
            // Update active TOC item
            setActiveTocId(id);
            
            // Remove highlight after 3 seconds
            setTimeout(() => {
                element.classList.remove('heading-highlighted');
            }, 3000);
        } else {
            console.error('Element not found with id:', id);
        }
    };

    // Share highlighted text
    const handleShareHighlightedText = (platform) => {
        const articleUrl = window.location.href;
        const articleTitle = currentBlog?.title || '';
        
        if (platform === 'twitter') {
            const tweetText = `"${selectedText}" - ${articleTitle}`;
            window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(tweetText)}&url=${encodeURIComponent(articleUrl)}`, '_blank');
        } else if (platform === 'copy') {
            navigator.clipboard.writeText(selectedText).then(() => {
                showNotification('Quote copied to clipboard!');
            });
        }
        
        setShowHighlightMenu(false);
        window.getSelection().removeAllRanges();
    };

    // Show notification
    const showNotification = (message) => {
        const notification = document.createElement('div');
        notification.className = 'custom-notification';
        notification.innerHTML = `
            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            ${message}
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('fade-out');
            setTimeout(() => notification.remove(), 400);
        }, 3000);
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
                        className="px-6 py-3 rounded-lg font-semibold transition-all duration-200 bg-indigo-600 hover:bg-indigo-700 text-white"
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
            showNotification('Comment posted successfully!');
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
            case 'whatsapp':
                window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent(title + ' ' + url)}`);
                break;
            case 'reddit':
                window.open(`https://reddit.com/submit?url=${encodeURIComponent(url)}&title=${encodeURIComponent(title)}`);
                break;
            case 'telegram':
                window.open(`https://t.me/share/url?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`);
                break;
            case 'copy':
                navigator.clipboard.writeText(url);
                showNotification('Link copied to clipboard!');
                break;
        }
        setShowShareMenu(false);
    };

    const fontSizeClasses = {
        small: 'text-sm md:text-base',
        medium: 'text-base md:text-lg',
        large: 'text-lg md:text-xl'
    };
    
    const getFontSizeStyles = () => {
        const sizes = {
            small: { fontSize: '15px', lineHeight: '1.7' },
            medium: { fontSize: '18px', lineHeight: '1.8' },
            large: { fontSize: '21px', lineHeight: '1.9' }
        };
        return sizes[fontSize];
    };

    return (
        <div className={`min-h-screen ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'} relative`}>
            {/* Custom Styles */}
            <style>{`
                /* Article content font size override */
                .blog-reading * {
                    font-size: inherit !important;
                }
                
                .blog-reading h1 {
                    font-size: 2em !important;
                    margin-top: 1.5em;
                    margin-bottom: 0.75em;
                }
                
                .blog-reading h2 {
                    font-size: 1.6em !important;
                    margin-top: 1.4em;
                    margin-bottom: 0.7em;
                }
                
                .blog-reading h3 {
                    font-size: 1.3em !important;
                    margin-top: 1.3em;
                    margin-bottom: 0.65em;
                }
                
                .blog-reading h4, .blog-reading h5, .blog-reading h6 {
                    font-size: 1.1em !important;
                    margin-top: 1.2em;
                    margin-bottom: 0.6em;
                }
                
                .heading-highlighted {
                    background: linear-gradient(90deg, ${isDarkMode ? 'rgba(79, 70, 229, 0.2)' : 'rgba(99, 102, 241, 0.1)'} 0%, transparent 100%);
                    padding-left: 1rem !important;
                    border-left: 4px solid ${isDarkMode ? '#818cf8' : '#6366f1'};
                    border-radius: 4px;
                    animation: highlight-fade 3s ease-out;
                }
                
                @keyframes highlight-fade {
                    0% { background-color: ${isDarkMode ? 'rgba(79, 70, 229, 0.3)' : 'rgba(99, 102, 241, 0.2)'}; }
                    100% { background-color: transparent; }
                }
                
                .copy-button {
                    position: absolute;
                    top: 12px;
                    right: 12px;
                    background: rgba(59, 130, 246, 0.9);
                    color: white;
                    padding: 6px 12px;
                    border-radius: 6px;
                    font-size: 12px;
                    font-weight: 500;
                    cursor: pointer;
                    border: none;
                    opacity: 0;
                    transition: all 0.3s ease;
                    z-index: 10;
                }
                
                pre.ql-syntax:hover .copy-button {
                    opacity: 1;
                }
                
                pre.ql-syntax {
                    position: relative;
                    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
                    border: 1px solid #334155 !important;
                    border-radius: 12px !important;
                    padding: 48px 28px 24px 28px !important;
                    margin: 24px 0 !important;
                }
                
                pre.ql-syntax::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    height: 3px;
                    background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
                    border-radius: 12px 12px 0 0;
                }
                
                .custom-notification {
                    position: fixed;
                    bottom: 30px;
                    left: 50%;
                    transform: translateX(-50%);
                    background: linear-gradient(135deg, #1f2937, #111827);
                    color: white;
                    padding: 1rem 2rem;
                    border-radius: 12px;
                    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
                    z-index: 10000;
                    animation: fadeInUp 0.4s ease;
                    font-weight: 500;
                    display: flex;
                    align-items: center;
                    gap: 0.75rem;
                }
                
                .custom-notification.fade-out {
                    animation: fadeOut 0.4s ease;
                }
                
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translate(-50%, 30px);
                    }
                    to {
                        opacity: 1;
                        transform: translate(-50%, 0);
                    }
                }
                
                @keyframes fadeOut {
                    from {
                        opacity: 1;
                        transform: translate(-50%, 0);
                    }
                    to {
                        opacity: 0;
                        transform: translate(-50%, 10px);
                    }
                }
                
                .reaction-btn-active {
                    animation: reaction-pop 0.5s ease;
                }
                
                @keyframes reaction-pop {
                    0%, 100% { transform: scale(1); }
                    25% { transform: scale(1.2); }
                    50% { transform: scale(1.1); }
                    75% { transform: scale(1.15); }
                }
            `}</style>

            {/* Reading Progress Bar */}
            <div 
                className="fixed top-0 left-0 h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-cyan-500 z-50 transition-all duration-100"
                style={{ width: `${readingProgress}%` }}
            />

            {/* Image Zoom Modal */}
            {showImageModal && (
                <div 
                    className="fixed inset-0 bg-black bg-opacity-95 z-[10000] flex items-center justify-center p-12 cursor-zoom-out"
                    onClick={() => setShowImageModal(false)}
                >
                    <button 
                        className="absolute top-5 right-8 text-white text-5xl font-bold hover:text-gray-300 transition-colors"
                        onClick={() => setShowImageModal(false)}
                    >
                        &times;
                    </button>
                    <img src={modalImageSrc} alt="Zoomed" className="max-w-full max-h-full object-contain" />
                </div>
            )}

            {/* Highlight to Share Menu */}
            {showHighlightMenu && (
                <div 
                    className="highlight-menu fixed bg-gray-800 rounded-lg px-2 py-2 flex gap-2 shadow-2xl z-[1000]"
                    style={{ 
                        left: `${highlightMenuPosition.x}px`, 
                        top: `${highlightMenuPosition.y}px`,
                        transform: 'translateX(-50%)'
                    }}
                >
                    <button
                        onClick={() => handleShareHighlightedText('twitter')}
                        className="text-white px-3 py-2 hover:bg-gray-700 rounded transition-colors"
                        title="Share on Twitter"
                    >
                        <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
                        </svg>
                    </button>
                    <button
                        onClick={() => handleShareHighlightedText('copy')}
                        className="text-white px-3 py-2 hover:bg-gray-700 rounded transition-colors"
                        title="Copy quote"
                    >
                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </button>
                </div>
            )}

            {/* Font Size Controls */}
            <div className="fixed top-28 right-6 bg-white dark:bg-gray-800 rounded-xl px-3 py-3 shadow-2xl flex gap-2 z-[1000] border border-gray-200 dark:border-gray-700">
                {['small', 'medium', 'large'].map((size, idx) => (
                    <button
                        key={size}
                        onClick={() => handleFontSizeChange(size)}
                        className={`px-3 py-2 rounded-lg font-bold transition-all ${
                            fontSize === size
                                ? 'bg-indigo-600 text-white shadow-lg scale-110'
                                : isDarkMode
                                    ? 'bg-gray-700 text-gray-300 hover:bg-gray-600'
                                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                        }`}
                        title={`${size.charAt(0).toUpperCase() + size.slice(1)} font size`}
                    >
                        {idx === 0 ? 'A-' : idx === 2 ? 'A+' : 'A'}
                    </button>
                ))}
            </div>

            {/* Text-to-Speech Controls Panel */}
            {showSpeechControls && (
                <div className={`fixed top-52 right-6 w-80 rounded-xl px-4 py-4 shadow-2xl z-[1000] border ${
                    isDarkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'
                }`}>
                    <div className="flex items-center justify-between mb-4">
                        <h3 className={`font-bold ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                            🎙️ Audio Settings
                        </h3>
                        <button
                            onClick={() => setShowSpeechControls(false)}
                            className={`${isDarkMode ? 'text-gray-400 hover:text-white' : 'text-gray-500 hover:text-gray-900'}`}
                        >
                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    {/* Voice Selection */}
                    <div className="mb-4">
                        <label className={`block text-sm font-medium mb-2 ${isDarkMode ? 'text-gray-300' : 'text-gray-700'}`}>
                            Select Voice
                        </label>
                        <select
                            value={selectedVoice?.voiceURI || ''}
                            onChange={(e) => handleVoiceChange(e.target.value)}
                            className={`w-full px-3 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-indigo-500 ${
                                isDarkMode 
                                    ? 'bg-gray-700 border-gray-600 text-white' 
                                    : 'bg-white border-gray-300 text-gray-900'
                            }`}
                        >
                            {voices.map((voice) => (
                                <option key={voice.voiceURI} value={voice.voiceURI}>
                                    {voice.name} ({voice.lang})
                                </option>
                            ))}
                        </select>
                    </div>
                    
                    {/* Speed Control */}
                    <div className="mb-4">
                        <label className={`block text-sm font-medium mb-2 ${isDarkMode ? 'text-gray-300' : 'text-gray-700'}`}>
                            Speed: {speechRate}x
                        </label>
                        <input
                            type="range"
                            min="0.5"
                            max="2.0"
                            step="0.1"
                            value={speechRate}
                            onChange={(e) => handleSpeedChange(parseFloat(e.target.value))}
                            className="w-full"
                        />
                        <div className="flex justify-between text-xs text-gray-500 mt-1">
                            <span>0.5x (Slow)</span>
                            <span>1.0x (Normal)</span>
                            <span>2.0x (Fast)</span>
                        </div>
                    </div>
                    
                    {/* Quick Speed Buttons */}
                    <div className="flex gap-2">
                        {[0.75, 1.0, 1.25, 1.5].map((rate) => (
                            <button
                                key={rate}
                                onClick={() => handleSpeedChange(rate)}
                                className={`flex-1 px-2 py-1.5 rounded-lg text-sm font-medium transition-all ${
                                    speechRate === rate
                                        ? 'bg-indigo-600 text-white'
                                        : isDarkMode
                                            ? 'bg-gray-700 text-gray-300 hover:bg-gray-600'
                                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                                }`}
                            >
                                {rate}x
                            </button>
                        ))}
                    </div>
                </div>
            )}

            {/* Floating Reading Controls */}
            <div className="fixed bottom-6 right-6 flex flex-col gap-3 z-[1000]">
                {/* Time Remaining Badge */}
                {timeRemaining > 0 && (
                    <div className={`flex items-center gap-3 px-4 py-3 rounded-full shadow-2xl ${isDarkMode ? 'bg-gray-800 text-white' : 'bg-white text-gray-900'} border ${isDarkMode ? 'border-gray-700' : 'border-gray-200'}`}>
                        <div className="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                            <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div className="text-xs opacity-75">Time Left</div>
                            <div className="font-bold">{timeRemaining} min</div>
                        </div>
                    </div>
                )}

                {/* Back to Top */}
                {showBackToTop && (
                    <button
                        onClick={() => window.scrollTo({ top: 0, behavior: 'smooth' })}
                        className={`w-12 h-12 rounded-full shadow-2xl flex items-center justify-center transition-all hover:scale-110 ${isDarkMode ? 'bg-gray-800 text-white hover:bg-gray-700' : 'bg-white text-gray-700 hover:bg-gray-50'} border ${isDarkMode ? 'border-gray-700' : 'border-gray-200'}`}
                        title="Back to top"
                    >
                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    </button>
                )}

                {/* Print */}
                <button
                    onClick={() => window.print()}
                    className={`w-12 h-12 rounded-full shadow-2xl flex items-center justify-center transition-all hover:scale-110 ${isDarkMode ? 'bg-gray-800 text-white hover:bg-gray-700' : 'bg-white text-gray-700 hover:bg-gray-50'} border ${isDarkMode ? 'border-gray-700' : 'border-gray-200'}`}
                    title="Print article"
                >
                    <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                </button>

                {/* Text to Speech */}
                <button
                    onClick={toggleTextToSpeech}
                    className={`w-12 h-12 rounded-full shadow-2xl flex items-center justify-center transition-all hover:scale-110 ${
                        isSpeaking
                            ? 'bg-indigo-600 text-white'
                            : isDarkMode
                                ? 'bg-gray-800 text-white hover:bg-gray-700'
                                : 'bg-white text-gray-700 hover:bg-gray-50'
                    } border ${isDarkMode ? 'border-gray-700' : 'border-gray-200'}`}
                    title={isSpeaking ? (isPaused ? 'Resume audio' : 'Pause audio') : 'Listen to article'}
                >
                    {isSpeaking && !isPaused ? (
                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    ) : (
                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                        </svg>
                    )}
                </button>
                
                {/* Stop Audio (only show when playing) */}
                {isSpeaking && (
                    <button
                        onClick={stopTextToSpeech}
                        className={`w-12 h-12 rounded-full shadow-2xl flex items-center justify-center transition-all hover:scale-110 bg-red-600 text-white hover:bg-red-700 border border-red-700`}
                        title="Stop audio"
                    >
                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                        </svg>
                    </button>
                )}
                
                {/* Audio Settings */}
                <button
                    onClick={() => setShowSpeechControls(!showSpeechControls)}
                    className={`w-12 h-12 rounded-full shadow-2xl flex items-center justify-center transition-all hover:scale-110 ${
                        showSpeechControls
                            ? 'bg-indigo-600 text-white'
                            : isDarkMode
                                ? 'bg-gray-800 text-white hover:bg-gray-700'
                                : 'bg-white text-gray-700 hover:bg-gray-50'
                    } border ${isDarkMode ? 'border-gray-700' : 'border-gray-200'}`}
                    title="Audio settings"
                >
                    <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                </button>
            </div>

            {/* Hero Section */}
            <section className={`pt-10 pb-6 px-4 sm:px-8 lg:px-12 ${isDarkMode ? 'bg-gray-800' : 'bg-white'}`}>
                <div className="max-w-7xl mx-auto">
                    {/* Breadcrumb */}
                    <nav className="mb-8">
                        <ol className="flex items-center space-x-2 text-sm">
                            <li><a href="/" className={`${isDarkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors`}>Home</a></li>
                            <li className={`${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>/</li>
                            <li><a href="/blog" className={`${isDarkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900'} transition-colors`}>Blog</a></li>
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
                                            ? 'bg-red-600 text-white scale-105'
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
                                
                                <button
                                    onClick={() => setIsBookmarked(!isBookmarked)}
                                    className={`flex items-center space-x-2 px-4 py-2 rounded-lg transition-all duration-200 ${
                                        isBookmarked
                                            ? 'bg-yellow-600 text-white'
                                            : isDarkMode
                                                ? 'bg-gray-700 text-gray-300 hover:bg-gray-600'
                                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                                    }`}
                                    title="Bookmark"
                                >
                                    <svg className={`w-5 h-5 ${isBookmarked ? 'fill-current' : ''}`} fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                    </svg>
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
                                        <div className={`absolute top-full right-0 mt-2 w-56 rounded-xl shadow-2xl border z-10 ${
                                            isDarkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'
                                        }`}>
                                            <div className="py-2">
                                                {['twitter', 'facebook', 'linkedin', 'whatsapp', 'reddit', 'telegram', 'copy'].map(platform => (
                                                    <button
                                                        key={platform}
                                                        onClick={() => handleShare(platform)}
                                                        className={`w-full text-left px-4 py-2.5 text-sm hover:bg-gray-100 transition-colors duration-200 flex items-center gap-3 ${
                                                            isDarkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-700'
                                                        }`}
                                                    >
                                                        <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                            {platform === 'copy' ? (
                                                                <path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                            ) : (
                                                                <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
                                                            )}
                                                        </svg>
                                                        Share on {platform.charAt(0).toUpperCase() + platform.slice(1)}
                                                    </button>
                                                ))}
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

            {/* Article Content with TOC */}
            <section className={`pt-2 pb-16 px-4 sm:px-8 lg:px-12 ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto">
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-8">
                        {/* Main Content */}
                        <div className="lg:col-span-8">
                            <div className={`${isDarkMode ? 'bg-gray-800/80 border border-gray-700' : 'bg-white border border-gray-100'} rounded-2xl p-8 shadow-sm`}>
                                <div 
                                    ref={articleRef}
                                    className={`blog-reading prose max-w-none ${
                                        isDarkMode 
                                            ? 'prose-invert prose-headings:text-white prose-p:text-gray-300 prose-strong:text-white prose-code:text-indigo-400 prose-pre:bg-gray-900 prose-a:text-indigo-400' 
                                            : 'prose-headings:text-gray-900 prose-p:text-gray-600 prose-strong:text-gray-900 prose-code:text-indigo-600 prose-pre:bg-gray-100 prose-a:text-indigo-600'
                                    }`}
                                    style={getFontSizeStyles()}
                                    dangerouslySetInnerHTML={{ __html: currentBlog.content }}
                                />
                                
                                {/* Article Reactions */}
                                <div className={`mt-8 pt-8 border-t ${isDarkMode ? 'border-gray-700' : 'border-gray-200'}`}>
                                    <div className="mb-4 font-semibold text-lg">Was this article helpful?</div>
                                    <div className="flex flex-wrap gap-3">
                                        {[
                                            { key: 'helpful', emoji: '👍', label: 'Helpful' },
                                            { key: 'love', emoji: '❤️', label: 'Love' },
                                            { key: 'insightful', emoji: '💡', label: 'Insightful' },
                                            { key: 'bookmark', emoji: '🔖', label: 'Bookmark' }
                                        ].map(reaction => (
                                            <button
                                                key={reaction.key}
                                                onClick={() => handleReaction(reaction.key)}
                                                className={`flex items-center gap-2 px-5 py-3 rounded-full border-2 transition-all ${
                                                    reactions[reaction.key]
                                                        ? 'bg-indigo-600 border-indigo-600 text-white scale-105'
                                                        : isDarkMode
                                                            ? 'border-gray-600 text-gray-300 hover:border-indigo-500'
                                                            : 'border-gray-300 text-gray-700 hover:border-indigo-500'
                                                } ${reactions[reaction.key] ? 'reaction-btn-active' : ''}`}
                                            >
                                                <span className="text-xl">{reaction.emoji}</span>
                                                <span className="font-medium">{reaction.label}</span>
                                            </button>
                                        ))}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Table of Contents Sidebar */}
                        <div className="lg:col-span-4">
                            <div className="sticky top-24">
                                {/* Table of Contents */}
                                <div className={`${isDarkMode ? 'bg-gray-800 border border-gray-700' : 'bg-white border border-gray-100'} rounded-2xl p-6 shadow-sm mb-6`}>
                                    <div className="flex items-center justify-between mb-4">
                                        <h3 className={`text-lg font-bold ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                            <svg className="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                            </svg>
                                            Table of Contents
                                        </h3>
                                        {tocItems.length > 0 && (
                                            <button
                                                onClick={() => setShowToc(!showToc)}
                                                className={`${isDarkMode ? 'text-gray-400 hover:text-white' : 'text-gray-500 hover:text-gray-900'} transition-colors`}
                                            >
                                                <svg className={`w-5 h-5 transition-transform ${showToc ? '' : 'rotate-180'}`} fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 15l7-7 7 7" />
                                                </svg>
                                            </button>
                                        )}
                                    </div>
                                    
                                    {tocItems.length === 0 ? (
                                        <div className={`text-center py-4 ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                                            <svg className="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p className="text-sm">No headings found in article</p>
                                        </div>
                                    ) : showToc && (
                                        <ul className="space-y-1">
                                            {tocItems.map((item, index) => (
                                                <li key={index} style={{ paddingLeft: `${(item.level - 1) * 0.75}rem` }}>
                                                    <button
                                                        onClick={() => handleTocClick(item.id)}
                                                        className={`w-full text-left px-3 py-2 rounded-lg text-sm transition-all ${
                                                            activeTocId === item.id
                                                                ? isDarkMode
                                                                    ? 'bg-indigo-900 text-indigo-300 font-semibold border-l-4 border-indigo-500'
                                                                    : 'bg-indigo-100 text-indigo-900 font-semibold border-l-4 border-indigo-600'
                                                                : isDarkMode
                                                                    ? 'text-gray-400 hover:text-white hover:bg-gray-700'
                                                                    : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'
                                                        }`}
                                                    >
                                                        {item.text}
                                                    </button>
                                                </li>
                                            ))}
                                        </ul>
                                    )}
                                </div>

                                {/* Newsletter Widget */}
                                <div className={`${isDarkMode ? 'bg-gradient-to-br from-indigo-900 to-purple-900' : 'bg-gradient-to-br from-indigo-50 to-purple-50'} rounded-2xl p-6 text-center shadow-sm`}>
                                    <div className="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <svg className="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <h4 className={`text-lg font-bold mb-2 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                                        Subscribe to Newsletter
                                    </h4>
                                    <p className={`text-sm mb-4 ${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                                        Get the latest articles delivered to your inbox
                                    </p>
                                    <input
                                        type="email"
                                        placeholder="Your email address"
                                        className={`w-full px-4 py-3 rounded-lg mb-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 ${
                                            isDarkMode ? 'bg-gray-800 text-white border-gray-700' : 'bg-white text-gray-900 border-gray-300'
                                        } border`}
                                    />
                                    <button className="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition-colors">
                                        <svg className="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                        Subscribe
                                    </button>
                                    <p className="text-xs mt-3 opacity-75">No spam, unsubscribe anytime</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Comments Section */}
            <section className={`py-16 px-4 sm:px-8 lg:px-12 ${isDarkMode ? 'bg-gray-800' : 'bg-white'}`}>
                <div className="max-w-4xl mx-auto">
                    <h2 className={`text-3xl font-bold mb-8 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                        Comments ({comments.length})
                    </h2>
                    
                    {/* Add Comment Form */}
                    <form onSubmit={handleCommentSubmit} className="mb-12">
                        <div className={`${isDarkMode ? 'bg-gray-700' : 'bg-gray-50'} rounded-2xl p-6`}>
                            <div className="flex items-start space-x-4">
                                <div className="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
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
                                    <div className="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
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
