
    export const errorHandler = async (error) => { 
        
            if(error.response) { //Server Response

                if(error.response?.data?.message) {
                    let err = new Error(error.response.data.message);
                    if (error.response.data?.errors) {
                        err.validation = error.response.data?.errors;
                    }
                    throw err;
                } else if(error.response?.message) {
                    throw new Error("Unexpected error occurred");
                } else {
                    throw new Error("Unexpected error occurred");
                }

            } else if (error.request) { //Server No Response
                
                console.log("Server",error);
                throw  new Error("No response from server. Please check your network.");
            } else {
                console.log("Syntax",error);
                throw  new Error(error.message || "Unexpected error occurred");
            }
        
    }

    
export default {
    errorHandler,
}