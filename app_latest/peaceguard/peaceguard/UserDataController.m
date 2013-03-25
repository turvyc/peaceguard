//
//  UserDataController.m
//
//  Contributor(s): Ashley Lesperance
//
//  Copyright (c) 2013 Number 13 Developer's Group
//


#import "UserDataController.h"
#import "User.h"

@interface UserDataController ()

- (void) initializeDefaultUser;

@end

@implementation UserDataController

- (void) initializeDefaultUser
{
    self.currentUser = [[User alloc]initWithUsername:nil password: nil];
  
}

- (void)logUsername: (NSString *) username andPassword: (NSString *) password{
    
    self.currentUser.username = username;
    self.currentUser.password = password;
    
}

@end
