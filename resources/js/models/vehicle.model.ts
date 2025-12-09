import api from "@/plugins/axios";
import { errorHandler } from "@/services/responseHandleService";



/**
 * Fields definition
 */
export const fields = [

    // -------------------------
    // BASIC
    // -------------------------
    { key: "auction_id", label: "Auction", type: "number", group: "basic" },
    { key: "title", label: "Title", type: "text", group: "basic" },
    { key: "vehicle_id", label: "Vehicle", type: "number", group: "basic" },
    { key: "make_id", label: "Make", type: "number", group: "basic" },
    { key: "model_id", label: "Model", type: "number", group: "basic" },
    { key: "variant_id", label: "Variant", type: "number", group: "basic" },
    { key: "body_id", label: "Body Type", type: "number", group: "basic" },
    { key: "year", label: "Year", type: "number", group: "basic" },
    { key: "color_id", label: "Color", type: "number", group: "basic" },
    { key: "colorname", label: "Color Name", type: "text", group: "basic" },
    { key: "doors", label: "Doors", type: "number", group: "basic" },
    { key: "seats", label: "Seats", type: "number", group: "basic" },
    { key: "vin", label: "VIN", type: "text", group: "basic" },
    { key: "reg", label: "Registration", type: "text", group: "basic" },
    { key: "auction_date", label: "Auction Date", type: "text", group: "basic" },
    { key: "former_keepers", label: "former_keepers", type: "text", group: "basic" },
    { key: "equipments", label: "Equipments", type: "text", group: "basic" },


    // -------------------------
    // ENGINE / DRIVE
    // -------------------------
    { key: "fuel_type", label: "Fuel Type", type: "text", group: "engine" },
    { key: "fuel_details", label: "Fuel Details", type: "text", group: "engine" },
    { key: "transmission", label: "Transmission", type: "text", group: "engine" },
    { key: "transmission_details", label: "Transmission Details", type: "text", group: "engine" },
    { key: "cc", label: "CC", type: "number", group: "engine" },
    { key: "euro_status", label: "Euro Status", type: "text", group: "engine" },
    { key: "engine_runs", label: "Engine Runs", type: "text", group: "engine" },
    { key: "mileage", label: "Mileage", type: "number", group: "engine" },
    { key: "dvsa_mileage", label: "DVSA Mileage", type: "number", group: "engine" },
    { key: "mileage_warranted", label: "Mileage Warranted", type: "text", group: "engine" },

    // -------------------------
    // KEYS / GRADES
    // -------------------------
    { key: "keys", label: "Keys", type: "text", group: "engine" },
    { key: "grade", label: "Grade", type: "text", group: "engine" },

    // -------------------------
    // BIDDING / AUCTION
    // -------------------------
    { key: "lot", label: "Lot No", type: "text", group: "auction" },
    { key: "center_id", label: "Auction Center", type: "number", group: "auction" },
    { key: "start_date", label: "Start Date", type: "date", group: "auction" },
    { key: "end_date", label: "End Date", type: "date", group: "auction" },
    { key: "dor", label: "Date of Reg", type: "date", group: "auction" },
    { key: "bidding_history", label: "Bidding History", type: "textarea", group: "auction" },
    { key: "last_bid", label: "Last Bid", type: "number", group: "auction" },
    { key: "bidding_status", label: "Bidding Status", type: "text", group: "auction" },
    { key: "buy_now_price", label: "Buy Now Price", type: "number", group: "auction" },

    // -------------------------
    // PRICING (CAP / GLASS / AT)
    // -------------------------
    { key: "cap_new", label: "CAP New", type: "number", group: "pricing" },
    { key: "cap_retail", label: "CAP Retail", type: "number", group: "pricing" },
    { key: "cap_clean", label: "CAP Clean", type: "number", group: "pricing" },
    { key: "cap_average", label: "CAP Average", type: "number", group: "pricing" },
    { key: "cap_below", label: "CAP Below", type: "number", group: "pricing" },

    { key: "glass_new", label: "Glass New", type: "number", group: "pricing" },
    { key: "glass_retail", label: "Glass Retail", type: "number", group: "pricing" },
    { key: "glass_trade", label: "Glass Trade", type: "number", group: "pricing" },

    { key: "autotrader_retail_value", label: "AT Retail", type: "number", group: "pricing" },
    { key: "autotrader_trade_value", label: "AT Trade", type: "number", group: "pricing" },

    // -------------------------
    // MOT / LEGAL
    // -------------------------
    { key: "mot_expiry_date", label: "MOT Expiry", type: "date", group: "mot" },
    { key: "mot_due", label: "MOT Due", type: "date", group: "mot" },
    { key: "v5", label: "V5", type: "text", group: "mot" },
    { key: "vat_status", label: "VAT Status", type: "text", group: "mot" },

    // -------------------------
    // SERVICE / INSPECTION
    // -------------------------
    { key: "service_history", label: "Service History", type: "text", group: "service" },
    { key: "no_of_services", label: "No. of Services", type: "number", group: "service" },
    { key: "number_of_services_details", label: "Service Details", type: "textarea", group: "service" },
    { key: "last_service", label: "Last Service", type: "date", group: "service" },
    { key: "last_service_mileage", label: "Last Service Mileage", type: "number", group: "service" },
    { key: "inspection_report", label: "Inspection Report", type: "textarea", group: "service" },
    { key: "other_report", label: "Other Report", type: "textarea", group: "service" },
    { key: "inspection_date", label: "Inspection Date", type: "date", group: "service" },

    { key: "tyres_condition", label: "Tyres Condition", type: "text", group: "service" },
    { key: "brakes", label: "Brakes", type: "text", group: "service" },
    { key: "hubs", label: "Hubs", type: "text", group: "service" },

    // -------------------------
    // VENDOR / DEALER
    // -------------------------
    { key: "vendor", label: "Vendor", type: "text", group: "vendor" },
    { key: "imported", label: "Imported", type: "text", group: "vendor" },
    { key: "declarations", label: "Declarations", type: "textarea", group: "vendor" },

    // -------------------------
    // IMAGES / FILES
    // -------------------------
    { key: "images", label: "Images", type: "file", group: "files", accept: "image/*" },
    { key: "damaged_images", label: "Damaged Images", type: "file", group: "files", accept: "image/*" },

    // -------------------------
    // MISC
    // -------------------------
    { key: "features", label: "Features", type: "textarea", group: "misc" },
    { key: "equipment", label: "Equipment", type: "textarea", group: "misc" },
    { key: "additional_information", label: "Additional Info", type: "textarea", group: "misc" },
    { key: "damage_details", label: "Damage Details", type: "textarea", group: "misc" },

] as const;


export type VehicleObject = {

  [K in typeof fields[number]['key']]: 
    Extract<typeof fields[number], { key: K }> extends { type: infer T }
      ? T extends 'number' 
          ? number | undefined
          : T extends 'file'
            ? File[] | undefined
            : string | undefined
      : never;
};



/**
 * Vehicle Model
 */
export default class Vehicle {


    /**
     * Get Model Keys
     */
    static getModelKeys(): VehicleObject {

        const obj = {} as VehicleObject;
        return obj;
    }


    /**
     * Find by ID
     */
    static async find(id: number): Promise<{
        data: unknown[];
    }> {
        try {
            let res = await api.get('/api/user/auctionList/' + id, {
                params: {
                },
            })
            return res.data;
        } catch (error) {
            throw await errorHandler(error);
        }

    }

   static async getRelatedVehicle(options:{
            search?: string;
            page?: number;
            length?: number;
            platform?: number;
            id:number,
        }) : Promise<{
            data: unknown[];
            recordsFiltered: number;
            recordsTotal: number;
            page: number;
            length: number;
            last_page: number;
            offset: number;
        }> {
        
            try {
                let res = await api.get('/api/user/getRelatedVehicle/' + options.id, {
                    params: options,
                })
                return res.data;
            } catch (error) {
                throw await errorHandler(error);
            }
    }



//    static setVehicleDetail(obj: Partial<VehicleObject> = {}): VehicleObject {
//         const normalized = this.getModelKeys();
//         fields.forEach(f => {
//         if (obj[f.key] !== undefined) {
//             (normalized as any)[f.key] = obj[f.key];
//         }
//         });
//         return normalized;
//     }
    
    
}



// export const EmptyVehcile = Vehicle.getModelKeys();
