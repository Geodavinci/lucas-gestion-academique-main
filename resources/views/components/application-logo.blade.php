<svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <!-- Gradient definition -->
    <defs>
        <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#06b6d4;stop-opacity:1" />
        </linearGradient>
        <linearGradient id="accentGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#10b981;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#059669;stop-opacity:1" />
        </linearGradient>
    </defs>

    <!-- Background circle -->
    <circle cx="100" cy="100" r="95" fill="url(#logoGradient)" opacity="0.1"/>

    <!-- Main book/document shape -->
    <g transform="translate(100, 100)">
        <!-- Left page -->
        <path d="M -35 -40 L -10 -40 L -10 40 L -35 40 Q -45 35 -45 20 L -45 -20 Q -45 -35 -35 -40" fill="url(#logoGradient)" opacity="0.8"/>

        <!-- Right page -->
        <path d="M -10 -40 L 35 -40 Q 45 -35 45 -20 L 45 20 Q 45 35 35 40 L -10 40 L -10 -40" fill="url(#logoGradient)"/>

        <!-- Spine -->
        <rect x="-12" y="-40" width="4" height="80" fill="url(#accentGradient)" opacity="0.6"/>

        <!-- Text lines on right page -->
        <line x1="0" y1="-25" x2="30" y2="-25" stroke="white" stroke-width="2" opacity="0.7"/>
        <line x1="0" y1="-15" x2="30" y2="-15" stroke="white" stroke-width="2" opacity="0.7"/>
        <line x1="0" y1="-5" x2="25" y2="-5" stroke="white" stroke-width="1.5" opacity="0.6"/>
        <line x1="0" y1="5" x2="30" y2="5" stroke="white" stroke-width="1.5" opacity="0.6"/>
        <line x1="0" y1="15" x2="28" y2="15" stroke="white" stroke-width="1.5" opacity="0.6"/>
        <line x1="0" y1="25" x2="25" y2="25" stroke="white" stroke-width="1.5" opacity="0.6"/>

        <!-- Decorative accent -->
        <circle cx="35" cy="-28" r="3" fill="url(#accentGradient)"/>
    </g>
</svg>
