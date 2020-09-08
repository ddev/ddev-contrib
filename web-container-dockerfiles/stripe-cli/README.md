# Stripe CLI

Build, test, and manage your Stripe integration right from the terminal with [Stripe CLI](https://stripe.com/docs/stripe-cli).

## Installation

1. Copy `Dockerfile` inside your web container configuration `.ddev/web-build/`
2. Start/Restart your project and you are done! 🙌

## Check if it is working

```bash
ddev exec stripe --version
```

should output something like this

```bash
stripe version 1.5.1
```

Well done. Now you can start to listen to the stripe web hooks. Have fun 🎉

**Contributed by [@SuddenlyRust](https://github.com/SuddenlyRust)**
