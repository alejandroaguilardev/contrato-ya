interface EnvConfig {
    HOST_API: string;
    GOOGLE_RECAPTCHA: string;
}

function getEnvVariable<T = string>(key: string, defaultValue?: T): T {
    const value = import.meta.env[`${key}`] as T | undefined;
    if (!value && defaultValue === undefined) {
        throw new Error(`Missing environment variable: ${key}`);
    }
    return value ?? defaultValue!;
}

const envs: EnvConfig = {
    HOST_API: getEnvVariable('PUBLIC_HOST_API'),
    GOOGLE_RECAPTCHA: getEnvVariable('PUBLIC_GOOGLE_RECAPTCHA'),
};

export default envs;
