
//
//  Manager1414.h
//  linphone
//
//  Created by Yiftach Golan on 5/8/15.
//
//

#import <UIKit/UIKit.h>
#import "sqlite3.h"
@interface Manager1414 : NSObject {
    NSString    *databasePath;
    sqlite3     *contactDB;
}

+ (id)sharedManager;
- (void) init_db;
- (void) saveData:(NSString*) number;
- (NSString*) getData;
- (void) deleteData;
-(void) getFormattedData:(NSMutableString*) number_formatted_str;
- (UIImage*) download_image:(NSString*) number_str;
- (NSString*) get_public_ip_address;
- (void) clearProxyConfig;
- (void)addProxyConfig:(NSString*)username password:(NSString*)password domain:(NSString*)domain server:(NSString*)server;
- (void)registerPhoneNumber:(NSString*) phone_number_str;
- (void) setDeviceToken:(NSData*)device_token_id;
- (NSString*) getDeviceToken;
- (NSString*) getAddress;
- (NSString*) setUsernameDeatils:(NSString*)fname lname:(NSString*)lname email:(NSString*)email tokenid:(NSString*)tokenid;
- (NSString*) getNameFromNumber:(NSString*) phone_number;
- (NSString*) getDataFromURL:(NSString*) url_get;
- (void) getNumberFormat:(NSString*) number_str number_format:(NSMutableString*)number_format_str;
- (void) getRealIpAddress;
- (BOOL)dataIsValidPNG:(NSData *)data;

@property (nonatomic, retain) NSString* ip_address;
@property (nonatomic, retain) NSString* http_ip_address;
@property (nonatomic, copy) NSMutableString* m_message;
@property (nonatomic, retain) NSData* m_device_token;
@property (nonatomic, retain) NSString* address;

@end
