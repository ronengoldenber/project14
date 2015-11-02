//
//  UILoginViewController.h
//  call1414
//
//  Created by Yiftach Golan on 10/29/15.
//  Copyright © 2015 1414. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Manager1414.h"

@interface UILoginViewController : UIViewController
@property (weak, nonatomic) IBOutlet UIButton *UILoginButton;
@property (weak, nonatomic) IBOutlet UITextField *usernameTextField;
@property (weak, nonatomic) IBOutlet UITextField *passwordTextField;

@end
