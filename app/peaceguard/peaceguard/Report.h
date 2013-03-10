//
//  Report.h
//
//  Contributor(s): Ashley Lesperance, Jonas Yao
//
//  Copyright (c) 2013 Number 123 Developer's Group
//


#import <Foundation/Foundation.h>

@interface Report : NSObject

@property (nonatomic, copy) NSString *title;
@property (nonatomic, copy) NSString *description;

-(id)initWithName:(NSString*)title description:(NSString *) description;

@end

