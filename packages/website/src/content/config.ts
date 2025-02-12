import { defineCollection, z } from 'astro:content';

const socialCollection = defineCollection({
    schema: z.object({
        platform: z.string(),
        url: z.string(),
        icon: z.string(),
    }),
});

const contactsCollection = defineCollection({
    schema: z.object({
        name: z.string(),
        email: z.string().email(),
        phone: z.string().optional(),
        position: z.string().optional(),
        address: z.string().optional(),
        schedule: z.string().optional(),
    }),
});

const advisorsCollection = defineCollection({
    schema: z.object({
        name: z.string(),
        phoneNumber: z.string(),
        status: z.string(),
        imageUrl: z.string(),
        description: z.string().optional(),
    }),
});


export const collections = {
    'contact': contactsCollection,
    'socialLinks': socialCollection,
    'advisors': advisorsCollection,
};