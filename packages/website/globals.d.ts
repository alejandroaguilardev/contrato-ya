// globals.d.ts
declare var grecaptcha: {
    execute(siteKey: string, options: { action: string }): Promise<string>;
    getResponse: () => string;
    reset: () => void;
};
