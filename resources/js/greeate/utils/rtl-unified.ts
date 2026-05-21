export function getFlexDirection(rtl: boolean): string {
    return rtl ? 'flex-row-reverse' : 'flex-row';
}

export function getTextAlign(rtl: boolean): string {
    return rtl ? 'text-right' : 'text-left';
}

export function getIconMargin(margin: 'sm' | 'md' | 'lg', rtl: boolean): string {
    const margins = {
        sm: rtl ? 'ml-1' : 'mr-1',
        md: rtl ? 'ml-2' : 'mr-2',
        lg: rtl ? 'ml-3' : 'mr-3',
    };
    return margins[margin];
}

export function getSpaceX(rtl: boolean): string {
    return rtl ? 'space-x-reverse' : '';
}

export function getDirection(rtl: boolean): 'rtl' | 'ltr' {
    return rtl ? 'rtl' : 'ltr';
}

export function getFieldDirection(
    fieldType: 'email' | 'phone' | 'url' | 'text' | 'textarea' | 'number' | 'color' = 'text',
    rtl: boolean,
): 'rtl' | 'ltr' {
    if (fieldType === 'email' || fieldType === 'phone' || fieldType === 'url' || fieldType === 'number' || fieldType === 'color') {
        return 'ltr';
    }
    return rtl ? 'rtl' : 'ltr';
}

export function getInputTextAlign(
    fieldType: 'email' | 'phone' | 'url' | 'text' | 'textarea' | 'number' | 'color' = 'text',
    rtl: boolean,
): string {
    if (fieldType === 'email' || fieldType === 'phone' || fieldType === 'url' || fieldType === 'number' || fieldType === 'color') {
        return 'text-start';
    }
    return rtl ? 'text-right' : 'text-left';
}

export function getRTLUtilities(rtl: boolean, locale = 'en') {
    return {
        isRTL: rtl,
        locale,
        dir: getDirection(rtl),
        textAlign: getTextAlign(rtl),
        flexDirection: getFlexDirection(rtl),
        spaceX: getSpaceX(rtl),
        iconMargin: (margin: 'sm' | 'md' | 'lg' = 'md') => getIconMargin(margin, rtl),
        getFieldDir: (fieldType: 'email' | 'phone' | 'url' | 'text' | 'textarea' | 'number' | 'color' = 'text') =>
            getFieldDirection(fieldType, rtl),
        getInputTextAlign: (fieldType: 'email' | 'phone' | 'url' | 'text' | 'textarea' | 'number' | 'color' = 'text') =>
            getInputTextAlign(fieldType, rtl),
    };
}
