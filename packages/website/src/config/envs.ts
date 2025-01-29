interface EnvConfig {
    HOST_API: string;
    GOOGLE_RECAPTCHA: string;
    PUBLIC_META_PIXEL_ID: string;
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
    PUBLIC_META_PIXEL_ID: getEnvVariable('PUBLIC_META_PIXEL_ID'),
};

export default envs;
