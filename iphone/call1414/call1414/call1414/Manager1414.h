//
//  Manager1414.h
//  call1414
//
//  Created by Yiftach Golan on 10/30/15.
//  Copyright © 2015 1414. All rights reserved.
//
#import <foundation/Foundation.h>
@interface Manager1414 : NSObject {
    NSString *email;
    NSString *password;
}

@property (nonatomic, retain) NSString *email;
@property (nonatomic, retain) NSString *password;
#define UIColorFromRGB(rgbValue) [UIColor colorWithRed:((float)((rgbValue & 0xFF0000) >> 16))/255.0 green:((float)((rgbValue & 0xFF00) >> 8))/255.0 blue:((float)(rgbValue & 0xFF))/255.0 alpha:1.0]

+ (id)sharedManager;
- (void) updateServer:(NSString*)phoneNumber;
- (NSString *)convertIntoMD5:(NSString *) string;
- (void) callTo1414;
@end
