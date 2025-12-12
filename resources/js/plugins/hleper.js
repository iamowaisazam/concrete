

export const isFile = (value) => {

        
    return value instanceof File;
    
}

export const renderImage = (image) => {

    if (image instanceof File ) {
        return URL.createObjectURL(image);
    } else {
        return image;
    }
    
}




export default {
    isFile,
    renderImage

}