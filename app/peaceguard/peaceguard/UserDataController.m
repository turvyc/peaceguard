//
//  UserDataController.m
//
//  Contributor(s): Ashley Lesperance
//
//  Copyright (c) 2013 Number 123 Developer's Group
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



@end
