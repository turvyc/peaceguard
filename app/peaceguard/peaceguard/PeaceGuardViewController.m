//
//  PeaceGuardViewController.m
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-02-13.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "PeaceGuardViewController.h"
#import "User.h"
#import "UserDataController.h"

@interface PeaceGuardViewController ()

@end

@implementation PeaceGuardViewController

/*
- (void)awakeFromNib
{
    [super awakeFromNib];
    self.dataController = [[UserDataController alloc] init];
}*/

//- (BOOL)textFieldShouldReturn:(UITextField *)theTextField{
//    if (theTextField == self.username) {
//        [theTextField resignFirstResoponder];
//    }
//    if( theTextField == self.password){
//        [theTextField resignFirstResponder];
//    }
//    return YES;
//}

- (void)touchesBegan:(NSSet *)touches withEvent:(UIEvent *)event
{
    [self.view endEditing:YES];
}

- (BOOL) textFieldShouldReturn:(UITextField *)textField {
    [textField resignFirstResponder];
    return YES;
}
- (IBAction)Login:(id)sender {
    BOOL authentication =
    [self logUsername:self.username.text password:self.password.text];
    if( authentication == YES) {
        //the login is correct
        [self performSegueWithIdentifier:@"ToMainMenu" sender:self];
    }else{
        //Let the user know the login failed
        UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Login Failed"
                                                        message:@"The username or password was incorrect."
                                                       delegate:nil
                                              cancelButtonTitle:@"OK"
                                              otherButtonTitles:nil];
        [alert show];
    }
}

- (BOOL)logUsername: (NSString *) username password: (NSString *) password{
    self.user = [[User alloc]initWithUsername:@"admin" password: @"123"];
    NSString *tempname = self.user.username;
    NSString *temppassword = self.user.password;
    if([username isEqualToString:tempname]
       &&
       [password isEqualToString:temppassword])
    {
        return YES;
    }else{
        return NO;
    }
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.

}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


@end
