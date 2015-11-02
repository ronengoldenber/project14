//
//  Manager1414.m
//  call1414
//
//  Created by Yiftach Golan on 10/30/15.
//  Copyright © 2015 1414. All rights reserved.
//
@import UIKit;
#import <Foundation/Foundation.h>
#import "Manager1414.h"
#import <CommonCrypto/CommonDigest.h>
@implementation Manager1414

@synthesize email;
@synthesize password;

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
    if (self = [super init]) {
    }
    return self;
}

- (void)dealloc {
    // Should never be called, but just here for clarity really.
}

- (NSString *)convertIntoMD5:(NSString *) string {
    const char *cStr = [string UTF8String];
    unsigned char digest[16];
    CC_MD5( cStr, (unsigned int)strlen(cStr), digest ); // This is the md5 call
    NSMutableString *resultString = [NSMutableString stringWithCapacity:CC_MD5_DIGEST_LENGTH * 2];
    for(int i = 0; i < CC_MD5_DIGEST_LENGTH; i++)
        [resultString appendFormat:@"%02x", digest[i]];
    return  resultString;
}

- (void) updateServer:(NSString*)phoneNumber {
    NSString* ha1 = [self getHa1];
    NSString *noteDataString = [NSString stringWithFormat:@"phoneNumber=%@&ha1=%@", phoneNumber, ha1];
    NSURLSessionConfiguration *sessionConfiguration = [NSURLSessionConfiguration defaultSessionConfiguration];
    sessionConfiguration.HTTPAdditionalHeaders = @{@"api-key"       : @"API_KEY"};
    NSURLSession *session = [NSURLSession sessionWithConfiguration:sessionConfiguration];
    NSURL *url = [NSURL URLWithString:@"http://1414intl.com/call"];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:url];
    request.HTTPBody = [noteDataString dataUsingEncoding:NSUTF8StringEncoding];
    request.HTTPMethod = @"POST";
    NSURLSessionDataTask *postDataTask = [session dataTaskWithRequest:request completionHandler:^(NSData *data, NSURLResponse *response, NSError *error) {
        // The server answers with an error because it doesn't receive the params
        NSLog(@"Could not send post request %@", error);
    }];
    [postDataTask resume];
}
-(NSString*) getHa1 {
    NSString *md5 = [NSString stringWithFormat:@"%@:%@:%@", email, password, @"tmus"];
    return [self convertIntoMD5:md5];
}

-(void) callTo1414 {
    [[UIApplication sharedApplication] openURL:[NSURL URLWithString:@"tel:2532432123"]];
}

@end
