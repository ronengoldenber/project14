//
//  Manager1414.m
//  linphone
//
//  Created by Yiftach Golan on 5/8/15.
//
//
#import "Manager1414.h"
#import "LinphoneManager.h"

@implementation Manager1414 : NSObject
@synthesize ip_address;
@synthesize http_ip_address;
@synthesize m_device_token;
@synthesize m_message;
@synthesize address;

#pragma mark Singleton Methods
+ (id)sharedManager {
    static Manager1414 *sharedMyManager = nil;
    static dispatch_once_t onceToken;
    dispatch_once(&onceToken, ^{
        sharedMyManager = [[self alloc] init];
    });
    return sharedMyManager;
}

- (id)init {
    ip_address = [[NSString alloc] init];
    address = [[NSString alloc] init];
    http_ip_address = [[NSString alloc] init];
    http_ip_address = @"1.1.1.1";
    m_device_token = [[NSData alloc] init];
    if (self = [super init]) {
        [self init_db];
        self.m_message = [[NSMutableString alloc] init];
    }
    return self;
}

- (void)dealloc {
    [super dealloc];
    [ip_address release];
    [http_ip_address release];
    [m_device_token release];
    [m_message release];
    [address release];
}

- (void) init_db
{
    NSString *docsDir;
    NSArray *dirPaths;
    // Get the documents directory
    dirPaths = NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES);
    docsDir = [dirPaths objectAtIndex:0];
    // Build the path to the database file
    databasePath = [[NSString alloc] initWithString: [docsDir stringByAppendingPathComponent: @"info.db"]];
    NSFileManager *filemgr = [NSFileManager defaultManager];
    if ([filemgr fileExistsAtPath: databasePath ] != NO)
    {
        [filemgr release];
        return;
    }
    const char *dbpath = [databasePath UTF8String];
    if (sqlite3_open(dbpath, &contactDB) != SQLITE_OK)
    {
        NSLog(@"Could not open or create database");
        [filemgr release];
        return;
    }
    char *errMsg;
    const char *sql_stmt = "CREATE TABLE IF NOT EXISTS INFO (ID INTEGER PRIMARY KEY AUTOINCREMENT, NUMBER TEXT)";
    if (sqlite3_exec(contactDB, sql_stmt, NULL, NULL, &errMsg) != SQLITE_OK)
    {
        NSLog(@"Could not create table");
    }
    sqlite3_close(contactDB);
    [filemgr release];
}
- (void) saveData:(NSString*) number
{
    sqlite3_stmt    *statement;
    const char *dbpath = [databasePath UTF8String];
    if (sqlite3_open(dbpath, &contactDB) != SQLITE_OK)
    {
        return;
    }
    NSString *insertSQL = [NSString stringWithFormat: @"INSERT INTO info (id, number) VALUES (\"%@\", \"%@\")", @"0", number];
    const char *insert_stmt = [insertSQL UTF8String];
    sqlite3_prepare_v2(contactDB, insert_stmt, -1, &statement, NULL);
    sqlite3_step(statement);
    sqlite3_finalize(statement);
    sqlite3_close(contactDB);
}

- (void) deleteData
{
    sqlite3_stmt *statement;
    const char *dbpath = [databasePath UTF8String];
    if (sqlite3_open(dbpath, &contactDB) != SQLITE_OK)
    {
        return;
    }
    NSString *insertSQL = [NSString stringWithFormat: @"DELETE FROM info"];
    const char *insert_stmt = [insertSQL UTF8String];
    sqlite3_prepare_v2(contactDB, insert_stmt, -1, &statement, NULL);
    sqlite3_step(statement);
    sqlite3_finalize(statement);
    sqlite3_close(contactDB);
}

-(NSString*) getData
{
    const char *dbpath = [databasePath UTF8String];
    sqlite3_stmt *statement;
    NSString* number_db = @"";
    if (sqlite3_open(dbpath, &contactDB) != SQLITE_OK)
    {
        return number_db;
    }
    NSString *querySQL = [NSString stringWithFormat: @"SELECT number FROM info"];
    const char *query_stmt = [querySQL UTF8String];
    if (sqlite3_prepare_v2(contactDB, query_stmt, -1, &statement, NULL) == SQLITE_OK)
    {
        if (sqlite3_step(statement) == SQLITE_ROW)
        {
            number_db = [[NSString alloc] initWithUTF8String:(const char *) sqlite3_column_text(statement, 0)];
        }
        sqlite3_finalize(statement);
    }
    sqlite3_close(contactDB);
    return number_db;
}

-(void) getFormattedData:(NSMutableString*) number_formatted_str
{
    NSString* data = [self getData];
    [number_formatted_str setString:data];
    [self getNumberFormat:data number_format:number_formatted_str];
    [data release];
}
- (void) getNumberFormat:(NSString*) number_str number_format:(NSMutableString*)number_format_str
{
    int len = [number_str length];
    if(!len) {
        [number_format_str setString:number_str];
        return;
    }
    if([[number_str substringWithRange:(NSMakeRange(0, 1))] intValue] == 1) {
        if(len > 4 && len <= 7) {
            [number_format_str setString:[NSString stringWithFormat:@"1 %@-%@",
                                          [number_str substringWithRange:(NSMakeRange(1, 2+1))],
                                          [number_str substringWithRange:(NSMakeRange(4, len - 4))]]];
            return;
        }
        if(len >= 8 && len <= 11) {
            [number_format_str setString:[NSString stringWithFormat:@"1 (%@) %@-%@",
                                    [number_str substringWithRange:(NSMakeRange(1, 2+1))],
                                    [number_str substringWithRange:(NSMakeRange(4, 3))],
                                    [number_str substringWithRange:(NSMakeRange(7, len - 7))]]];
            return;
        }
        [number_format_str setString:[NSString stringWithFormat:@"1 %@",
                                      [number_str substringWithRange:(NSMakeRange(1, len - 1))]]];
        return;
    }
    if(len >= 4 && len <= 6) {
        [number_format_str setString:[NSString stringWithFormat:@"%@-%@",
                                      [number_str substringWithRange:(NSMakeRange(0, 3))],
                                      [number_str substringWithRange:(NSMakeRange(3, len - 3))]]];
        return;
    }
    if(len >= 7 && len <= 10) {
        [number_format_str setString:[NSString stringWithFormat:@"(%@) %@-%@",
                                      [number_str substringWithRange:(NSMakeRange(0, 3))],
                                      [number_str substringWithRange:(NSMakeRange(3, 3))],
                                      [number_str substringWithRange:(NSMakeRange(6, len - 6))]]];
        return;
    }
    [number_format_str setString:number_str];
    return;
}

- (BOOL)dataIsValidPNG:(NSData *)data
{
    if (!data || data.length < 12)
    {
        return NO;
    }
    
    NSInteger totalBytes = data.length;
    const char *bytes = (const char *)[data bytes];
    
    return (bytes[0] == (char)0x89 && // PNG
            bytes[1] == (char)0x50 &&
            bytes[2] == (char)0x4e &&
            bytes[3] == (char)0x47 &&
            bytes[4] == (char)0x0d &&
            bytes[5] == (char)0x0a &&
            bytes[6] == (char)0x1a &&
            bytes[7] == (char)0x0a &&
            
            bytes[totalBytes - 12] == (char)0x00 && // IEND
            bytes[totalBytes - 11] == (char)0x00 &&
            bytes[totalBytes - 10] == (char)0x00 &&
            bytes[totalBytes - 9] == (char)0x00 &&
            bytes[totalBytes - 8] == (char)0x49 &&
            bytes[totalBytes - 7] == (char)0x45 &&
            bytes[totalBytes - 6] == (char)0x4e &&
            bytes[totalBytes - 5] == (char)0x44 &&
            bytes[totalBytes - 4] == (char)0xae &&
            bytes[totalBytes - 3] == (char)0x42 &&
            bytes[totalBytes - 2] == (char)0x60 &&
            bytes[totalBytes - 1] == (char)0x82);
}

- (UIImage*) download_image:(NSString*) number_str
{
    NSLog(@"Downloading...");
    NSString *docDir = [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) objectAtIndex:0];
    NSString *pngFilePath = [NSString stringWithFormat:@"%@/%@.png",docDir, number_str];
    bool is_file_exists =[[NSFileManager defaultManager] fileExistsAtPath:pngFilePath];
    NSData *data1 = nil;
    if(is_file_exists)
    {
        data1 = [[NSFileManager defaultManager] contentsAtPath:pngFilePath];
        is_file_exists = [self dataIsValidPNG:data1];
    }
    if(!is_file_exists)
    {
        NSString* str = [NSString stringWithFormat:@"http://%@/upload/%@.png", http_ip_address, number_str];
        UIImage *image = [[UIImage alloc] initWithData:[NSData dataWithContentsOfURL:[NSURL URLWithString:str]]];
        NSLog(@"%f,%f",image.size.width,image.size.height);
        NSLog(@"%@",docDir);
        NSLog(@"saving png");
        NSString *pngFilePath = [NSString stringWithFormat:@"%@/%@.png",docDir, number_str];
        NSData *data1 = [NSData dataWithData:UIImagePNGRepresentation(image)];
        [data1 writeToFile:pngFilePath atomically:YES];
        return image;
    }
    UIImage *image = [[UIImage alloc] initWithData:data1];
    return image;
}

- (NSString*) get_public_ip_address
{
    NSURL *url = [NSURL URLWithString:@"http://checkip.dyndns.org"];
    NSMutableURLRequest* request = [NSMutableURLRequest requestWithURL:url];
    [request setURL:url];
    [request setHTTPMethod:@"GET"];
    [request setValue:@"application/json" forHTTPHeaderField:@"Content-Type"];
    NSError *error;
    NSURLResponse *response;
    NSData *data = [NSURLConnection sendSynchronousRequest:request returningResponse:&response error:&error];
    NSString* str = [NSString stringWithUTF8String:[data bytes]];
    str = [str substringFromIndex:76];
    NSArray *substrings = [str componentsSeparatedByString:@"<"];
    return substrings[0];
}
- (void) clearProxyConfig
{
    linphone_core_clear_proxy_config([LinphoneManager getLc]);
    linphone_core_clear_all_auth_info([LinphoneManager getLc]);
}
- (void)addProxyConfig:(NSString*)username password:(NSString*)password domain:(NSString*)domain server:(NSString*)server {
    [self clearProxyConfig];
    if(server == nil) {
        server = domain;
    }
    NSLog(@"+++++++++++addProxyConfig1++++++++");
    LinphoneProxyConfig* proxyCfg = linphone_core_create_proxy_config([LinphoneManager getLc]);
    char normalizedUserName[256];
    LinphoneAddress* linphoneAddress = linphone_address_new("sip:user@domain.com");
    linphone_proxy_config_normalize_number(proxyCfg, [username cStringUsingEncoding:[NSString defaultCStringEncoding]], normalizedUserName, sizeof(normalizedUserName));
    linphone_address_set_username(linphoneAddress, normalizedUserName);
    linphone_address_set_domain(linphoneAddress, [domain UTF8String]);
    NSLog(@"+++++++++++addProxyConfig2++++++++");
    const char* identity = linphone_address_as_string_uri_only(linphoneAddress);
    linphone_proxy_config_set_identity(proxyCfg, identity);
    linphone_proxy_config_set_server_addr(proxyCfg, [server UTF8String]);
    LinphoneAuthInfo* info = linphone_auth_info_new([username UTF8String]
                                                    , NULL, [password UTF8String]
                                                    , NULL
                                                    , NULL
                                                    ,linphone_proxy_config_get_domain(proxyCfg));
    NSLog(@"+++++++++++addProxyConfig4++++++++");
    if([server compare:domain options:NSCaseInsensitiveSearch] != NSOrderedSame) {
        linphone_proxy_config_set_route(proxyCfg, [server UTF8String]);
    }
    linphone_proxy_config_expires(proxyCfg, 3600);
    linphone_proxy_config_enable_register(proxyCfg, true);
    linphone_core_add_proxy_config([LinphoneManager getLc], proxyCfg);
    linphone_core_set_default_proxy([LinphoneManager getLc], proxyCfg);
    linphone_core_add_auth_info([LinphoneManager getLc], info);
    linphone_core_set_firewall_policy([LinphoneManager getLc], LinphonePolicyNoFirewall);
    NSLog(@"Proxy is registered");
}
- (void) getRealIpAddress
{
    if (![http_ip_address isEqualToString:@"1.1.1.1"])
    {
        return;
    }
    NSString *ip = [self get_public_ip_address];
    ip_address = @"50.148.128.58";
    http_ip_address = @"50.148.128.58:80";
    if ([ip isEqualToString:@"50.148.128.58"])
    {
        ip_address = @"192.168.1.110";
        http_ip_address = @"192.168.1.110:80";
    }
    return;
}
- (void)registerPhoneNumber:(NSString*) phone_number_str;
{
    //    NSString *ip_sip = @"50.148.128.58;transport=tcp";
    NSString *ip_sip = @"50.148.128.58";
    NSString *ip = [self get_public_ip_address];
    ip_address = @"50.148.128.58";
    http_ip_address = @"50.148.128.58:80";
    if ([ip isEqualToString:@"50.148.128.58"])
    {
        ip_address = @"192.168.1.110";
        http_ip_address = @"192.168.1.110:80";
        //      ip_sip = @"192.168.1.110:5060;transport=tcp";
        ip_sip = @"192.168.1.110:5060";
    }
    NSString* username = phone_number_str;
    NSString* password = @"choochee1";
    NSString* domain = @"tmusqa.com";
    NSString* server = ip_sip;
    [[Manager1414 sharedManager] addProxyConfig:username password:password domain:domain server:server];
}
- (void) setDeviceToken:(NSData*)device_token_id
{
    self.m_device_token = [device_token_id retain];
    NSLog(@"the token is %@", self.m_device_token);
}
- (NSString*) getDeviceToken
{
    NSLog(@"the token is %@", self.m_device_token);
    NSString* deviceToken = [[[[[self.m_device_token description]
                                stringByReplacingOccurrencesOfString: @"<" withString: @""]
                               stringByReplacingOccurrencesOfString: @">" withString: @""]
                              stringByReplacingOccurrencesOfString: @" " withString: @""] retain];
    NSLog(@"the token is %@", deviceToken);
    return deviceToken;
}
- (NSString*) getAddress
{
    return address;
}
- (NSString*) getNameFromNumber:(NSString*) phone_number
{
    NSString* url = [NSString stringWithFormat:@"backend/voiceapi.php?api=get_name_from_phone_number&number=%@", phone_number];
    return [self getDataFromURL:url];
}
- (NSString*) setUsernameDeatils:(NSString*)fname lname:(NSString*)lname email:(NSString*)email tokenid:(NSString*)tokenid; {
    NSRange needleRange = NSMakeRange(0, 11);
    NSString *needle = [tokenid substringWithRange:needleRange];
    NSString* url = [NSString stringWithFormat:@"backend/voiceapi.php?api=set_username_details&fname=%@&lname=%@&email=%@&username=%@", fname, lname, email, needle];
    return [self getDataFromURL:url];
}
- (NSString*) getDataFromURL:(NSString*) url_get
{
    [self getRealIpAddress];
    NSString* request_str = [NSString stringWithFormat:@"http://%@/%@", http_ip_address, url_get];
    NSURL *url = [NSURL URLWithString: request_str];
    NSMutableURLRequest* request = [[[NSMutableURLRequest alloc] initWithURL:url] autorelease];
    [request setURL:url];
    [request setHTTPMethod:@"GET"];
    NSError *error = nil;
    NSURLResponse *response = nil;
    
    NSData *data = [NSURLConnection sendSynchronousRequest:request returningResponse:&response error:&error];
    NSString* str = [NSString stringWithUTF8String:[data bytes]];
    NSLog(@"The name is [%@], request url [%@]", str, request_str);
    return str;
}

@end