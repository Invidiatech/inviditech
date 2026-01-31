import React, { useState, useEffect } from 'react';

const TimestampConverter = () => {
    const [timestamp, setTimestamp] = useState('');
    const [dateTime, setDateTime] = useState('');
    const [currentTime, setCurrentTime] = useState(Date.now());
    const [statusMessage, setStatusMessage] = useState({ text: '', type: '' });

    useEffect(() => {
        document.title = 'Free Timestamp Converter - Unix Timestamp to Date and Vice Versa';
        let metaDescription = document.querySelector('meta[name="description"]');
        if (metaDescription) {
            metaDescription.content = 'Free online timestamp converter. Convert Unix timestamp to human-readable date and vice versa. Supports milliseconds, seconds, and various date formats. Perfect for developers.';
        }
        
        const interval = setInterval(() => setCurrentTime(Date.now()), 1000);
        return () => clearInterval(interval);
    }, []);

    const showMessage = (text, type) => {
        setStatusMessage({ text, type });
        setTimeout(() => setStatusMessage({ text: '', type: '' }), 4000);
    };

    const timestampToDate = () => {
        if (!timestamp) {
            showMessage('Please enter a timestamp', 'error');
            return;
        }
        
        try {
            const ts = parseInt(timestamp);
            const date = ts.toString().length === 10 ? new Date(ts * 1000) : new Date(ts);
            
            if (isNaN(date.getTime())) throw new Error('Invalid timestamp');
            
            setDateTime(date.toISOString().slice(0, 16));
            showMessage('✓ Converted to date successfully!', 'success');
        } catch (error) {
            showMessage('✗ Invalid timestamp format', 'error');
        }
    };

    const dateToTimestamp = () => {
        if (!dateTime) {
            showMessage('Please select a date and time', 'error');
            return;
        }
        
        try {
            const date = new Date(dateTime);
            if (isNaN(date.getTime())) throw new Error('Invalid date');
            
            setTimestamp(Math.floor(date.getTime() / 1000).toString());
            showMessage('✓ Converted to timestamp successfully!', 'success');
        } catch (error) {
            showMessage('✗ Invalid date format', 'error');
        }
    };

    const useCurrentTime = () => {
        const now = Math.floor(Date.now() / 1000);
        setTimestamp(now.toString());
        setDateTime(new Date().toISOString().slice(0, 16));
        showMessage('✓ Current time loaded!', 'success');
    };

    const copyValue = (value, type) => {
        navigator.clipboard.writeText(value).then(() => {
            showMessage(`✓ ${type} copied to clipboard!`, 'success');
        });
    };

    const clear = () => {
        setTimestamp('');
        setDateTime('');
        showMessage('✓ Cleared all data', 'success');
    };

    const formatDate = (timestamp) => {
        const date = new Date(timestamp);
        return {
            iso: date.toISOString(),
            utc: date.toUTCString(),
            local: date.toLocaleString(),
            date: date.toLocaleDateString(),
            time: date.toLocaleTimeString()
        };
    };

    const currentFormatted = formatDate(currentTime);

    return (
        <div className="min-h-screen bg-gradient-to-br from-violet-600 via-purple-600 to-indigo-600 py-20 px-4 sm:px-6 lg:px-8">
            <div className="max-w-6xl mx-auto">
                <div className="bg-white rounded-3xl shadow-2xl overflow-hidden">
                    <div className="bg-gradient-to-r from-violet-600 to-purple-600 text-white py-12 px-8 text-center">
                        <div className="flex items-center justify-center mb-4">
                            <i className="fas fa-clock text-5xl"></i>
                        </div>
                        <h1 className="text-4xl md:text-5xl font-bold mb-4">Timestamp Converter</h1>
                        <p className="text-xl text-violet-100">Convert between Unix timestamp and human-readable date</p>
                    </div>

                    <div className="p-8 md:p-12">
                        {statusMessage.text && (
                            <div className={`p-4 rounded-xl mb-6 border-l-4 ${statusMessage.type === 'success' ? 'bg-green-50 text-green-800 border-green-500' : 'bg-red-50 text-red-800 border-red-500'}`}>
                                {statusMessage.text}
                            </div>
                        )}

                        {/* Current Time Display */}
                        <div className="bg-gradient-to-r from-violet-50 to-purple-50 rounded-2xl p-6 mb-8">
                            <h3 className="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <i className="fas fa-history text-violet-600"></i> Current Time
                            </h3>
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div className="bg-white p-4 rounded-lg">
                                    <div className="text-gray-600 mb-1">Unix Timestamp</div>
                                    <div className="font-mono font-bold text-violet-600 text-lg">{Math.floor(currentTime / 1000)}</div>
                                </div>
                                <div className="bg-white p-4 rounded-lg">
                                    <div className="text-gray-600 mb-1">ISO Format</div>
                                    <div className="font-mono text-sm text-gray-800">{currentFormatted.iso}</div>
                                </div>
                                <div className="bg-white p-4 rounded-lg">
                                    <div className="text-gray-600 mb-1">Local Time</div>
                                    <div className="font-mono text-sm text-gray-800">{currentFormatted.local}</div>
                                </div>
                                <div className="bg-white p-4 rounded-lg">
                                    <div className="text-gray-600 mb-1">UTC Time</div>
                                    <div className="font-mono text-sm text-gray-800">{currentFormatted.utc}</div>
                                </div>
                            </div>
                            <button onClick={useCurrentTime} className="mt-4 w-full bg-violet-600 hover:bg-violet-700 text-white px-4 py-2 rounded-lg font-semibold transition-all flex items-center justify-center gap-2">
                                <i className="fas fa-download"></i> Use Current Time
                            </button>
                        </div>

                        {/* Timestamp to Date */}
                        <div className="mb-8">
                            <h3 className="text-lg font-semibold text-gray-800 mb-4">Timestamp to Date</h3>
                            <div className="flex gap-3">
                                <input type="text" value={timestamp} onChange={(e) => setTimestamp(e.target.value)} className="flex-1 p-4 border-2 border-gray-300 rounded-xl font-mono focus:outline-none focus:ring-4 focus:ring-violet-200 focus:border-violet-500" placeholder="Enter Unix timestamp (e.g., 1640000000)" />
                                <button onClick={timestampToDate} className="px-6 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white rounded-xl font-semibold transition-all hover:shadow-lg">
                                    <i className="fas fa-arrow-right"></i>
                                </button>
                                <button onClick={() => copyValue(timestamp, 'Timestamp')} className="px-6 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl font-semibold transition-all">
                                    <i className="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        {/* Date to Timestamp */}
                        <div className="mb-8">
                            <h3 className="text-lg font-semibold text-gray-800 mb-4">Date to Timestamp</h3>
                            <div className="flex gap-3">
                                <input type="datetime-local" value={dateTime} onChange={(e) => setDateTime(e.target.value)} className="flex-1 p-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-violet-200 focus:border-violet-500" />
                                <button onClick={dateToTimestamp} className="px-6 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white rounded-xl font-semibold transition-all hover:shadow-lg">
                                    <i className="fas fa-arrow-left"></i>
                                </button>
                                <button onClick={() => copyValue(dateTime, 'Date')} className="px-6 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl font-semibold transition-all">
                                    <i className="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <button onClick={clear} className="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-xl font-semibold transition-all flex items-center justify-center gap-2">
                            <i className="fas fa-trash"></i> Clear All
                        </button>
                    </div>
                </div>

                {/* SEO Content */}
                <div className="mt-12 bg-white rounded-3xl shadow-xl p-8 md:p-12">
                    <h2 className="text-3xl font-bold text-gray-900 mb-6">What is Unix Timestamp?</h2>
                    <p className="text-gray-700 leading-relaxed mb-6">
                        A Unix timestamp (also known as POSIX time or Epoch time) is a system for tracking time as a running count of seconds 
                        since January 1, 1970, 00:00:00 UTC (the Unix Epoch). Our free timestamp converter tool helps you easily convert 
                        between Unix timestamps and human-readable dates in both directions.
                    </p>

                    <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">Common Use Cases</h3>
                    <ul className="list-disc list-inside text-gray-700 space-y-2 mb-6">
                        <li><strong>Database Queries:</strong> Convert timestamps from database records to readable dates</li>
                        <li><strong>API Development:</strong> Work with timestamp-based API responses and requests</li>
                        <li><strong>Log Analysis:</strong> Convert server log timestamps to human-readable format</li>
                        <li><strong>Debugging:</strong> Understand when events occurred in your application</li>
                        <li><strong>Date Calculations:</strong> Calculate time differences using timestamps</li>
                        <li><strong>Scheduling:</strong> Convert scheduled times to timestamps for cron jobs</li>
                        <li><strong>Data Migration:</strong> Convert dates when migrating between systems</li>
                    </ul>

                    <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">Timestamp Formats</h3>
                    <div className="space-y-3 mb-6">
                        <div className="border-l-4 border-violet-500 pl-4">
                            <h4 className="font-semibold text-gray-900">10-digit (Seconds)</h4>
                            <p className="text-sm text-gray-700">Standard Unix timestamp in seconds. Example: 1640000000</p>
                        </div>
                        <div className="border-l-4 border-purple-500 pl-4">
                            <h4 className="font-semibold text-gray-900">13-digit (Milliseconds)</h4>
                            <p className="text-sm text-gray-700">JavaScript timestamp in milliseconds. Example: 1640000000000</p>
                        </div>
                    </div>

                    <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">Important Notes</h3>
                    <ul className="list-disc list-inside text-gray-700 space-y-2">
                        <li>Timestamps are timezone-independent (always in UTC)</li>
                        <li>JavaScript uses milliseconds, most other languages use seconds</li>
                        <li>Year 2038 problem: 32-bit systems will overflow on January 19, 2038</li>
                        <li>Always validate timestamps before using them</li>
                        <li>Consider daylight saving time when displaying local times</li>
                    </ul>
                </div>
            </div>
        </div>
    );
};

export default TimestampConverter;
