# 🤖 AI SESSION STARTER PROMPT

> **Use this prompt in OpenAI Codex CLI or any AI assistant to start a new session with full project context**

---

## 📋 COPY & PASTE THIS PROMPT (UPDATED: October 5, 2025):

```
I'm working on the OFYS (Outdoor Activity Booking Platform) project. Before we start, please read these two important files to understand the project context and where we left off:

1. **@CLAUDE.md** - Contains the session memory, current status, last stopping point, completed tasks, and next steps
2. **@AGENTS.md** - Contains the complete technical architecture, development guidelines, and best practices

After reading both files, please:
1. Look for the "🔴 🚀 START HERE FOR NEW AI SESSION 🚀 🔴" section in CLAUDE.md
2. Confirm you understand the project structure
3. Tell me where we stopped in the last session (October 5, 2025 - Evening)
4. Summarize the current status (what's completed, what's in progress, what's pending)
5. Ask me what I'd like to work on next

Remember:
- This is a Laravel 12 project with Blade + jQuery + Tailwind CSS
- Livewire and Alpine.js have been REMOVED - don't use them
- Project follows role-based organization (Admin/Customer/Provider/Guest)
- Guest pages (Home & Activities) are now production-ready with animations
- Color scheme: Yellow/Blue for guest pages, Teal/Emerald for provider pages
- There are uncommitted changes (both guest and provider sections)

Ready to continue from where we left off!
```

---

## 🎯 ALTERNATIVE SHORT PROMPT:

```
Hi! I'm continuing work on OFYS project. Please read @CLAUDE.md and @AGENTS.md first to get full context. Look for the "🔴 START HERE" section in CLAUDE.md, then tell me where we stopped (Oct 5, 2025 evening) and what's next.
```

---

## 💡 FOR OPENAI CODEX CLI:

### Option 1: Start with Context
```bash
# Navigate to project directory first
cd /Users/mrpixel/Documents/ofys/ofys

# Then start your AI session with:
"Read @CLAUDE.md and @AGENTS.md to understand the OFYS project context. Tell me where we stopped and what we're working on."
```

### Option 2: Direct File Reference
```bash
# In OpenAI Codex CLI, use @ to reference files
"@CLAUDE.md @AGENTS.md - Review these files and continue from last session"
```

### Option 3: Detailed Start
```bash
"I'm working on OFYS project. Read @CLAUDE.md for session memory and @AGENTS.md for technical guidelines. We stopped while working on Provider functionality. Confirm you understand the context and show me the current status."
```

---

## 🔧 FOR CURSOR AI / GITHUB COPILOT:

```
Context: OFYS - Outdoor Activity Booking Platform (Laravel 12)

Please read:
- @CLAUDE.md (session memory & progress)
- @AGENTS.md (technical architecture)

Then tell me:
1. Where did we stop?
2. What's the current status?
3. What should we work on next?

Project uses: Blade, jQuery, Tailwind CSS (NO Livewire/Alpine.js)
Current focus: Provider functionality
```

---

## 🎨 FOR CHATGPT:

```
I'm continuing work on the OFYS project (Outdoor Activity Booking Platform built with Laravel 12).

Please read these two files first to get full context:

**File 1: CLAUDE.md**
[Paste CLAUDE.md content or upload file]

**File 2: AGENTS.md**
[Paste AGENTS.md content or upload file]

After reading both files, please:
- Confirm you understand where we stopped
- Summarize current status (completed/in-progress/pending)
- Tell me what uncommitted changes exist
- Ask what I want to work on next

Important reminders:
- NO Livewire or Alpine.js (already removed)
- Use Blade + jQuery + Tailwind CSS
- Follow role-based organization
- Currently on: feature/major-refactor-code-providers branch
```

---

## 📱 FOR CLAUDE (New Conversation):

```
Hi Claude! I'm continuing the OFYS project development. Please read these two context files:

1. @CLAUDE.md - Your memory from last session
2. @AGENTS.md - Technical development guide

After reading, tell me:
- Where we stopped (look for "STOPPED HERE" section)
- What changes are uncommitted
- What's next on the priority list

Then ask me what I'd like to work on. Ready to pick up exactly where we left off!
```

---

## 🚀 QUICK START CHECKLIST

When starting a new AI session:

- [ ] Open terminal in project directory: `/Users/mrpixel/Documents/ofys/ofys`
- [ ] Copy the appropriate prompt from above
- [ ] Paste into your AI assistant (Codex CLI, Cursor, ChatGPT, Claude, etc.)
- [ ] Wait for AI to read both files and confirm context
- [ ] AI will tell you where you stopped
- [ ] AI will ask what to work on next
- [ ] Continue seamlessly! 🎉

---

## 💾 AFTER EACH SESSION:

**Always tell the AI to:**
```
"Before we end, please update @CLAUDE.md with:
1. What we completed this session
2. Where we're stopping now (update STOPPED HERE section)
3. What's next for the following session
4. Any new issues or notes

Keep @AGENTS.md updated if we changed architecture or added new patterns."
```

---

## 📝 NOTES:

- The `@` symbol tells most modern AI tools to reference a specific file
- Always start from the project root directory
- Both CLAUDE.md and AGENTS.md must be read for full context
- Update CLAUDE.md at the end of EVERY session
- Update AGENTS.md only when architecture/patterns change

---

## 🎯 EXPECTED AI RESPONSE:

After using this prompt, the AI should respond with something like:

```
✅ I've read both CLAUDE.md and AGENTS.md.

📍 Last Session Summary (October 5, 2025 - Evening):
- ✅ Fixed hero section height (from min-h-screen to 550px)
- ✅ Fixed left column overflow (proper 50/50 split)
- ✅ Implemented auto-rotating marketing subtitles (4 messages, 5.5s intervals)
- ✅ Updated all documentation files
- 🔴 STOPPED: Home page hero section complete with animations

📊 Current Status:
- Branch: feature/major-refactor-code-providers
- Last Updated: October 5, 2025 (Evening)
- Uncommitted changes:
  • Guest pages: simple-welcome.blade.php, activities/index.blade.php
  • Provider pages: Multiple views (from earlier session)
  • Documentation: CLAUDE.md, AGENTS.md, PROMPT1.md
  • New files: ResetPasswordSeeder.php, breadcrumbs partial, tests

✅ Completed: 
  - Home page with animated hero section (rotating images & marketing text)
  - Activities page with advanced filtering & grid/list views
  - Authentication fixes (ADMIN & PROVIDER passwords reset)
  - Color scheme standardization (Yellow/Blue guest, Teal/Emerald provider)

🚧 In Progress: Ready for next task
⚠️ Known Issue: Register page 500 error (not yet fixed)

🎯 What would you like to work on next?
```

---

**Last Updated**: October 5, 2025 (Evening)  
**Created by**: Session consolidation task  
**Purpose**: Ensure zero context loss between AI sessions  
**Latest Update**: Added "START HERE" marker in CLAUDE.md for quick session resumption

---

## 🔗 RELATED FILES:

- **CLAUDE.md** - Session memory (read first)
- **AGENTS.md** - Technical guide (read second)
- **This file (PROMPT1.md)** - How to start new sessions

---

*Save this prompt and use it every time you start a new AI session on this project!*

