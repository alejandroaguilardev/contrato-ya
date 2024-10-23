interface EnvConfig {
    PUBLIC_HOST_API: string;
    PUBLIC_GOOGLE_PUBLIC_KEY: string;
}

function getEnvVariable<T = string>(key: string, defaultValue?: T): T {
    const value = import.meta.env[key] as T | undefined;
    if (!value && defaultValue === undefined) {
        throw new Error(`Missing environment variable: ${key}`);
    }
    return value ?? defaultValue!;
}

const envs: EnvConfig = {
    PUBLIC_HOST_API: getEnvVariable('PUBLIC_HOST_API'),
    PUBLIC_GOOGLE_PUBLIC_KEY: getEnvVariable('PUBLIC_GOOGLE_PUBLIC_KEY'),
};

export default envs;
