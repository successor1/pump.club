# Memex - Decentralized Meme Bonding Curve

![Memex Banner](https://cdn.scriptoshi.com/scriptoshi/banner.jpg)

**The #1 full featured meme tokens launchpad.**

## Quick Links

-   📚 [Online Documentation](https://docs.memex.scriptoshi.com)
-   🔧 [Documentation Repository](https://github.com/scriptoshi/memex-docs) - Fork or contribute to our docs
-   📜 [Smart Contracts Repository](https://github.com/scriptoshi/memex-contracts) - Core blockchain contracts

    Memex is a sophisticated decentralized application (dApp) designed for creating, hosting and managing meme token launches on a bonding curve. A bonding curve allows for token trading even before the token reaches marketcap. Built for EVM-compatible chains, Memex leverages the automated market making (AMM) constant product algorithm and a secure prebonding mechanism to create a reliable and profitable platform for administrators, meme creators, and meme traders.

## Demo Access

To fully test the demo, ensure you have a working web3 wallet. Any connected address can access admin.

[![Frontend Demo](https://cdn.scriptoshi.com/envato/frontend-demo.jpg)](https://memex.scriptoshi.com)
[![Admin Demo](https://cdn.scriptoshi.com/envato/admin-demo.jpg)](https://memex.scriptoshi.com/admin)

## Technical Architecture

### Backend Stack

-   Laravel v11.31
-   MySQL/PostgreSQL database
-   RESTful API architecture
-   Web3 integration for blockchain interactions

### Frontend Stack

-   Vue.js 3.x with Composition API
-   Tailwind CSS 3.x for styling
-   Inertia.js for SPA functionality
-   Shadcn-vue components
-   Trading view integration for charts

## Core Features

### Decentralized Architecture

-   Fully decentralized system with smart contract-based operations
-   AMM (Constant product Formula) bonding curve for optimal price discovery
-   Innovative prebond mechanism ensuring project viability
-   Automatic liquidity migration to major DEXes
-   No code instant solidity contract deployments
-   Automatic Contract source verification at etherscan

### Security & Integration

-   Support for Uniswap, Sushiswap, PancakeSwap, and UniswapV3-compatible platforms
-   Automatic LP lock for 10 years with secure fee claiming for developers
-   Web3 authentication eliminating password-related vulnerabilities
-   Built-in launchpad chat system for community engagement

## Revenue Streams for Platform Administrators

### Multiple Income Sources

-   Deploy fees collection - Charge users for launchpad creation with blockchain-based fee collection
-   Trading fees collection - Earn from all sales during the bonding period
-   Top Ads revenue - Monetize through premium advertisement placement
-   Featured Launchpads (Coming soon) - Premium listing opportunities
-   Video Streaming services (Coming soon) - Additional monetization channel

## Supported Blockchain Networks

Currently integrated networks:

![Binance](https://cdn.scriptoshi.com/envato/binance.jpg)
![Arbitrum](https://cdn.scriptoshi.com/envato/arbitrum.jpg)
![Base](https://cdn.scriptoshi.com/envato/base.jpg)
![Blast](https://cdn.scriptoshi.com/envato/blast.jpg)
![Linea](https://cdn.scriptoshi.com/envato/linea.jpg)
![Sepolia](https://cdn.scriptoshi.com/envato/sepolia.jpg)

_More networks coming soon! Custom chain integration available upon request._

## Smart Contract Architecture

### Factory Pattern Implementation

The system employs a factory pattern for contract deployment, offering:

1. **Gas Efficiency**: Utilizes clone proxies to reduce deployment costs by up to 60%
2. **Centralized Management**: Factory serves as a hub for all contract deployments
3. **Standardization**: Ensures consistency across all deployed contracts
4. **Cost Control**: Optimizes gas consumption for contract deployment

### Deployment Costs

Gas costs vary by network:

-   Layer 1 networks (e.g., Ethereum): $8-12 USD
-   Layer 2 networks (e.g., Base): $4-6 USD

## Technical Requirements

### Server Requirements

-   PHP >= 8.2
-   MySQL >= 8.0 or PostgreSQL >= 14
-   Node.js >= 16.x
-   Composer

### Required PHP Extensions

-   BCMath
-   Ctype
-   JSON
-   Mbstring
-   OpenSSL
-   PDO
-   Tokenizer
-   XML

## Installation

1. Clone the repository:

```bash
git clone https://github.com/your-org/memex-launchpad.git
cd memex-launchpad
```

2. Install PHP dependencies:

```bash
composer install
```

3. Install JavaScript dependencies:

```bash
npm install
```

4. Configure environment variables:

```bash
cp .env.example .env
php artisan key:generate
```

5. Set up the database:

```bash
php artisan migrate
```

## Key Benefits

-   Enterprise-grade security through decentralized architecture
-   Multiple revenue streams for platform administrators
-   Seamless integration with major DEXes
-   Regular updates and feature additions
-   Comprehensive documentation and support

## What's Included

-   Complete source code
-   Detailed documentation
-   Dedicated support via Github, Codecanyon, Telegram and Discord
-   Regular updates and improvements
-   Installation and setup guide

## Support & Updates. I provide a free limitted support service for

-   Installation assistance
-   Hot Bug fixes
-   Technical questions
-   Basic feature requests

**Note:** This is a complex Web3 application that requires basic familiarity with blockchain technology and smart contract deployment. Our comprehensive documentation will guide you through the setup process.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## In case you need help. contact me

There are so many people contacting me, so be brief and respectful. Also I do this in my freetime, so im online 3-4 hours daily.

[Skype: ![skype](https://cdn.scriptoshi.com/Skype.png)](https://join.skype.com/invite/aKBehNElcDhg)
[Telegram ![telegram-logo](https://cdn.scriptoshi.com/telegram.png)](https://t.me/freshdropsadmin)
network conditions.

## I need support keeping servers up and running.

Did this help you? support me by donating any amount crypto:

### EVM Networks (ETH, BNB, etc.)

`0x14Bf01BCd1D415BFf5675EE586Cd71bB2d58baA0`

![EVM Networks QR Code](https://cdn.scriptoshi.com/scriptoshi/0x14Bf01BCd1D415BFf5675EE586Cd71bB2d58baA0.jpg)

### Bitcoin (BTC)

`14NU4N7RPUyqPSmU4Cu7ovtBJfuvS5AVUm`

![Bitcoin QR Code](https://cdn.scriptoshi.com/scriptoshi/14NU4N7RPUyqPSmU4Cu7ovtBJfuvS5AVUm.jpg)

## Disclaimer

While Memex implements various security measures, users should conduct their own due diligence when deploying contracts or launching tokens. Gas costs mentioned are approximate and may vary based on network conditions.
