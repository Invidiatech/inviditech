# 📋 Table of Contents - Testing Guide

## ✅ What I Fixed:

### 1. **Better Heading Detection**
- Increased delay from 100ms to 500ms (gives content time to render)
- Added console logs to debug
- Only adds headings that have text content
- Adds `scroll-margin-top` to headings for smooth scrolling

### 2. **Improved Scroll Function**
- Uses `getBoundingClientRect()` for accurate positioning
- Better offset calculation (120px for fixed header)
- Console logs for debugging
- Auto-highlights clicked heading for 3 seconds

### 3. **Better Visual Feedback**
- Shows message if no headings found
- Hover effects on TOC items
- Active item highlighted with border
- Smooth transitions

### 4. **Debug Information**
- Console shows: "Found headings: X"
- Console shows: "Added TOC item: [heading text]"
- Console shows: "TOC clicked: heading-1"
- Console shows: "Scrolling to: 500"

---

## 🧪 How to Test:

### **Step 1: Open Browser Console**
Press `F12` to see debug info

### **Step 2: Load Article Page**
Look in console for:
```
Found headings: 5
Added TOC item: Introduction (H2)
Added TOC item: Getting Started (H2)
Added TOC item: Installation (H3)
...
TOC items: [{id: 'heading-0', text: 'Introduction', level: 2}, ...]
```

### **Step 3: Check Table of Contents**
Look at right sidebar:
- Should show "Table of Contents" heading
- Should list all headings from article
- Sub-headings should be indented

**If you see:**
- "No headings found in article" → Article has no h1-h6 tags
- Empty TOC → Check console for errors

### **Step 4: Click TOC Item**
1. Click any item in TOC
2. Watch console:
   ```
   TOC clicked: heading-2
   Element found: <h2 id="heading-2">...</h2>
   Scrolling to: 850
   ```
3. Page should scroll smoothly to that heading
4. Heading should flash with highlight (blue background)
5. Active TOC item should be highlighted

---

## 🎯 Expected Behavior:

### **When TOC Works:**
1. ✅ TOC shows list of headings
2. ✅ Click heading → Page scrolls
3. ✅ Heading flashes blue
4. ✅ Active item highlighted in TOC
5. ✅ Smooth scroll animation

### **Visual Indicators:**
```
Table of Contents 🔽
├─ Introduction          ← H2 (no indent)
├─ Getting Started       ← H2 (no indent)
│  ├─ Installation       ← H3 (indented)
│  └─ Configuration      ← H3 (indented)
└─ Conclusion            ← H2 (no indent)
```

### **When You Click:**
```
1. Click "Installation" in TOC
2. Page scrolls to that section
3. "Installation" heading gets blue highlight
4. TOC item "Installation" shows with colored border
5. Highlight fades after 3 seconds
```

---

## 🔍 Debugging:

### **Problem: No TOC Items Show**

**Check Console:**
```
Found headings: 0  ← No headings in article
```

**Solutions:**
1. Article content might not have h1-h6 tags
2. Content not loaded yet
3. Try refreshing page

**Test Manually:**
```javascript
// In console:
document.querySelectorAll('.blog-reading h1, .blog-reading h2, .blog-reading h3')
// Should return array of heading elements
```

---

### **Problem: Click Doesn't Scroll**

**Check Console:**
```
TOC clicked: heading-2
Element found: null  ← Element not found!
```

**Solutions:**
1. Heading ID might be wrong
2. Element not in DOM yet

**Test Manually:**
```javascript
// In console:
document.getElementById('heading-0')
// Should return the heading element
```

---

### **Problem: Scrolls to Wrong Position**

**Check Console:**
```
Scrolling to: 500  ← Check if this is correct
```

**Possible Causes:**
- Fixed header height is wrong (should be ~120px)
- Page layout changed
- Content shifted

**Adjust Offset:**
If scrolls too high or too low, change the offset in code:
```javascript
const offsetPosition = elementPosition - 120; // Try 100 or 150
```

---

## 📊 Console Output Example:

**When Page Loads:**
```
Found headings: 6
Added TOC item: Introduction (H2)
Added TOC item: Features (H2)
Added TOC item: Core Features (H3)
Added TOC item: Advanced Features (H3)
Added TOC item: Getting Started (H2)
Added TOC item: Conclusion (H2)
TOC items: (6) [{…}, {…}, {…}, {…}, {…}, {…}]
```

**When You Click TOC:**
```
TOC clicked: heading-1
Element found: <h2 id="heading-1">Features</h2>
Scrolling to: 856
```

---

## 🎨 Visual States:

### **Normal TOC Item:**
```
┌──────────────────────┐
│ Getting Started      │  ← Gray text, hover effect
└──────────────────────┘
```

### **Hovered TOC Item:**
```
┌──────────────────────┐
│ Getting Started      │  ← Darker background
└──────────────────────┘
```

### **Active TOC Item:**
```
┌──────────────────────┐
│█ Getting Started     │  ← Blue background + border
└──────────────────────┘
```

### **Heading Highlight:**
```
┌─────────────────────────────────────┐
│█ Getting Started                    │  ← Blue gradient background
│  This section explains...           │     Fades after 3 seconds
└─────────────────────────────────────┘
```

---

## 🧪 Manual Tests:

### **Test 1: Create Test Article**
Add headings to your article:
```html
<h2>Introduction</h2>
<p>Some content...</p>

<h2>Main Topic</h2>
<p>More content...</p>

<h3>Subtopic</h3>
<p>Details...</p>
```

### **Test 2: Check TOC Generation**
```javascript
// In console after page loads:
const headings = document.querySelectorAll('.blog-reading h1, .blog-reading h2, .blog-reading h3, .blog-reading h4, .blog-reading h5, .blog-reading h6');
console.log('Headings:', headings.length);
Array.from(headings).forEach((h, i) => {
    console.log(i, h.tagName, h.textContent);
});
```

### **Test 3: Test Scroll Function**
```javascript
// In console:
const element = document.getElementById('heading-0');
if (element) {
    const pos = element.getBoundingClientRect().top + window.pageYOffset - 120;
    window.scrollTo({ top: pos, behavior: 'smooth' });
}
```

---

## 💡 Quick Fixes:

### **If TOC is Empty:**
1. Open console
2. Check "Found headings: X"
3. If X = 0:
   - Your article has no h1-h6 tags
   - Add some headings to content
4. If X > 0 but TOC empty:
   - Check for JavaScript errors
   - Refresh page

### **If Click Doesn't Work:**
1. Open console
2. Click TOC item
3. Look for error messages
4. Check if "Element found: ..." shows element or null
5. If null → Heading IDs not set properly

### **If Scroll Position Wrong:**
1. TOC scrolls but stops too high/low
2. Adjust offset in code (change 120 to different number)
3. Or check if your header height is different

---

## ✅ Success Checklist:

- [ ] Console shows "Found headings: X" (X > 0)
- [ ] TOC sidebar shows list of headings
- [ ] Sub-headings are indented
- [ ] Click TOC item → Console shows "TOC clicked: ..."
- [ ] Console shows "Element found: <h2>..."
- [ ] Console shows "Scrolling to: ..."
- [ ] Page scrolls smoothly to heading
- [ ] Heading flashes blue for 3 seconds
- [ ] Active TOC item highlighted with border
- [ ] No errors in console

---

## 🎉 Expected Experience:

1. **User opens article**
   → TOC automatically generates from headings

2. **User sees TOC in sidebar**
   → Clean list with proper indentation

3. **User clicks "Installation"**
   → Page smoothly scrolls to that section
   → Heading highlights in blue
   → TOC shows "Installation" as active

4. **User scrolls manually**
   → Active TOC item updates automatically
   → Shows which section you're reading

5. **User clicks another heading**
   → Scrolls to new section
   → Previous highlight removed
   → New section highlighted

---

## 📱 Mobile Behavior:

On mobile:
- TOC appears above content (not sidebar)
- Can collapse/expand with arrow button
- Touch-friendly click targets
- Smooth scroll still works

---

Try it now! Check the console and let me know what you see! 🚀
