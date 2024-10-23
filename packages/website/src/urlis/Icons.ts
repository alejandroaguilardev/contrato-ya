import EmailIcon from '../../public/assets/icons/email.svg';
import FacebookIcon from '../../public/assets/icons/facebook.svg';
import InstagramIcon from '../../public/assets/icons/instagram.svg';
import WhatsAppIcon from '../../public/assets/icons/whatsapp.svg';

export const socialNetworksIcons: Record<string, any> = {
    email: EmailIcon,
    facebook: FacebookIcon,
    instagram: InstagramIcon,
    whatsapp: WhatsAppIcon,
} as const;
