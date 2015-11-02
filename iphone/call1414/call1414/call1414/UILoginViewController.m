//
//  UILoginViewController.m
//  call1414
//
//  Created by Yiftach Golan on 10/29/15.
//  Copyright © 2015 1414. All rights reserved.
//

#import "UILoginViewController.h"

@interface UILoginViewController ()
@end

@implementation UILoginViewController
@synthesize usernameTextField;
@synthesize passwordTextField;
- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
/*    UIView *statusBarRect  = [[UIView alloc] initWithFrame:CGRectMake(0, 0, 600, 20)];
    statusBarRect.backgroundColor = UIColorFromRGB(0xFF3385);
    [self.view addSubview:statusBarRect];
    [self setNeedsStatusBarAppearanceUpdate];*/
    UIView *paddingView = [[UIView alloc] initWithFrame:CGRectMake(0, 0, 5, 20)];
    usernameTextField.leftView = paddingView;
    usernameTextField.leftViewMode = UITextFieldViewModeAlways;
    
    UIView *passwordPaddingView = [[UIView alloc] initWithFrame:CGRectMake(0, 0, 5, 20)];
    passwordTextField.leftView = passwordPaddingView;
    passwordTextField.leftViewMode = UITextFieldViewModeAlways;
}

-(UIBarPosition)positionForBar:(id<UIBarPositioning>)bar {
    return UIBarPositionTopAttached;
}

- (UIStatusBarStyle)preferredStatusBarStyle {
    return UIStatusBarStyleLightContent;
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

/*
#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}
*/

@end
